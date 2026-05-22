<?php

/**
 * Divi Theme Builder conditions for Polylang.
 *
 * Hooks into `et_theme_builder_template_settings_options` (Divi 4+) to expose
 * a "Languages (Polylang)" group in the Divi Theme Builder condition picker,
 * so that templates (header, footer, body) can be assigned per language
 * directly from the Divi Theme Builder UI ("Use on" / "Exclude from").
 *
 * The validate callback `lsdp_theme_builder_validate_polylang_language()` is
 * registered as a standalone function (not a method) because Divi resolves
 * it by name via call_user_func().
 *
 * Compatibility: Divi 4.0+ and Divi 5.
 *
 * Changelog:
 *  - 1.0.6.1 : Initial implementation.
 *  - 1.0.6.2 : Fixed "Template Conditions only apply to homepage" bug.
 *             Raised condition priority from 60 to 75 so language templates
 *             are not overridden by generic "All Pages/Posts" templates (70).
 *             Rewrote validate callback to use pll_get_post_language() and
 *             pll_get_term_language() as primary sources, avoiding stale
 *             language cookies on subdomain-per-language Polylang setups.
 *  - 1.0.7.0 : Fixed "English footer only applies to homepage" bug.
 *             Removed $type restriction from validate callback: pll_get_post_language()
 *             is now attempted for any non-zero $id regardless of the $type string
 *             Divi passes (which may be 'page', 'post', 'singular', 'front_page',
 *             etc. depending on Divi version).  Also improved filter_layouts_by_lang
 *             to use pll_get_post_language() / pll_get_term_language() instead of
 *             relying solely on pll_current_language().
 *             Modified: 2026-05-22 — Marco Traina <https://www.trainaepartners.it>
 *
 * @package Language_Switcher_For_Divi_Polylang
 * @since   1.0.6.1
 * @author  Marco Traina <info@trainaepartners.it>
 * @modified 2026-05-22 Marco Traina <https://www.trainaepartners.it>
 */

if (! defined('ABSPATH')) {
    die('Direct access forbidden.');
}

/**
 * Class LSDP_Theme_Builder_Conditions
 *
 * Registers Polylang language conditions inside the Divi Theme Builder UI.
 * Each active Polylang language appears as a selectable condition item.
 */
class LSDP_Theme_Builder_Conditions
{

    public function __construct()
    {
        add_filter('et_theme_builder_template_settings_options', array($this, 'add_polylang_options'));
    }

    /**
     * Adds a "Languages (Polylang)" group to the Theme Builder condition options.
     *
     * Each Polylang language becomes a selectable condition whose ID follows
     * the Divi separator convention: `language:polylang:{slug}`.
     * Divi splits the ID on `ET_THEME_BUILDER_SETTING_SEPARATOR` (`:`) and
     * passes the resulting array to the validate callback.
     *
     * @param array $options Existing condition groups keyed by group ID.
     * @return array Modified options with the Polylang group appended.
     */
    public function add_polylang_options($options)
    {
        if (! function_exists('pll_languages_list')) {
            return $options;
        }

        $languages = pll_languages_list(array('fields' => ''));

        if (empty($languages) || ! is_array($languages)) {
            return $options;
        }

        $settings = array();

        foreach ($languages as $lang) {
            if (! is_object($lang) || ! isset($lang->slug, $lang->name)) {
                continue;
            }

            $settings[] = array(
                'id'       => 'language:polylang:' . sanitize_key($lang->slug),
                'label'    => esc_html($lang->name),
                // Priority 75: intentionally higher than Divi's "All <post_type>" (70)
                // so a language-specific template is not shadowed by a generic one,
                // but lower than "Specific Term" (80) and "Specific Post" (100).
                'priority' => 75,
                'validate' => 'lsdp_theme_builder_validate_polylang_language',
            );
        }

        if (empty($settings)) {
            return $options;
        }

        $options['polylang_languages'] = array(
            'label'    => esc_html__('Languages (Polylang)', 'language-switcher-for-divi-polylang'),
            'settings' => $settings,
        );

        return $options;
    }
}

/**
 * Validates whether the current page language matches the condition.
 *
 * Divi calls this function by name at render time for every template that
 * has a Polylang language condition set in its "Use on" or "Exclude from"
 * list. Must be a global function, not a class method, because Divi resolves
 * validate callbacks as plain callables via call_user_func().
 *
 * Detection strategy (most-to-least reliable):
 *
 *  1. For any request with a valid post ID: `pll_get_post_language( $id )`
 *     reads the post's own Polylang language metadata directly from the DB.
 *     This is immune to stale language cookies (subdomain setups) and does
 *     not depend on the exact `$type` string Divi passes — which may differ
 *     across Divi versions (e.g. 'singular', 'front_page', 'page', 'post').
 *     Returns empty for term IDs or posts without a Polylang language
 *     assignment, in which case we fall through.
 *
 *  2. For term archive pages: `pll_get_term_language( $id )`.
 *
 *  3. Fallback for all other request types (author, date, search, 404,
 *     post-type archives): `pll_current_language()` which reads the language
 *     from the URL prefix/subdomain/cookie/browser header.
 *
 * @param string $type    Request type as reported by Divi (e.g. 'singular',
 *                        'front_page', 'page', 'post', 'term', etc.).
 * @param string $subtype Post type or taxonomy slug for the current request.
 * @param int    $id      Current object ID (post ID, term ID, etc.).
 * @param array  $setting The condition ID split on ':'. Index 2 holds the
 *                        Polylang language slug set by the user in the builder.
 * @return bool True if the current Polylang language equals the condition slug.
 */
function lsdp_theme_builder_validate_polylang_language($type, $subtype, $id, $setting)
{
    if (! function_exists('pll_current_language')) {
        return false;
    }

    $slug = isset($setting[2]) ? $setting[2] : '';
    if ('' === $slug) {
        return false;
    }

    $id = (int) $id;

    // ── 1. Post-level language metadata ──────────────────────────────────────
    // Modified 2026-05-22 by Marco Traina <https://www.trainaepartners.it>:
    // Removed the previous in_array($type, ['singular','front_page']) guard so
    // pll_get_post_language() is attempted for ANY $type value Divi may pass
    // (e.g. 'page', 'post', 'singular', 'front_page' — varies by Divi version).
    // pll_get_post_language() returns empty/false for term IDs and for posts
    // without a Polylang language assignment, so falling through is always safe.
    if ($id > 0 && function_exists('pll_get_post_language')) {
        $post_lang = pll_get_post_language($id);
        if (! empty($post_lang)) {
            return $post_lang === $slug;
        }
    }

    // ── 2. Term archive pages ─────────────────────────────────────────────────
    if ($id > 0 && function_exists('pll_get_term_language')) {
        $term_lang = pll_get_term_language($id);
        if (! empty($term_lang)) {
            return $term_lang === $slug;
        }
    }

    // ── 3. Fallback: browsing-language detection (URL prefix / subdomain / cookie) ─
    $current = pll_current_language();
    return ! empty($current) && $current === $slug;
}
