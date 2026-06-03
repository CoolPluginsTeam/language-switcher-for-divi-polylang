<?php

/**
 * Theme Builder Language Map — Divi 4 & 5 compatible.
 *
 * Provides:
 *  1. An admin settings page (Polylang → Theme Builder) where each Divi
 *     Theme Builder template can be assigned to a specific Polylang language.
 *  2. A filter on `et_theme_builder_template_layouts` that clears the resolved
 *     layouts when the template's assigned language does not match the current
 *     Polylang language, falling back to the default Divi rendering.
 *
 * Note: layout filtering only applies to singular pages (where Divi reports
 * the template ID). For archive pages, no filtering is performed; use the
 * Theme Builder UI conditions (provided by LSDP_Theme_Builder_Conditions)
 * for language-based filtering on archives.
 *
 * Changelog:
 *  - 1.0.7   : Initial implementation (admin page + filter_layouts_by_lang).
 *  - 1.0.7.1 : filter_layouts_by_lang now uses pll_get_post_language() and
 *             pll_get_term_language() as primary language sources instead of
 *             relying solely on pll_current_language(), fixing false mismatches
 *             on directory-prefix and other Polylang free configurations.
 *             Modified: 2026-05-22 — Marco Traina <https://www.trainaepartners.it>
 *
 * @package Language_Switcher_For_Divi_Polylang
 * @since   1.0.7
 * @modified 2026-05-22 Marco Traina <https://www.trainaepartners.it>
 */

if (! defined('ABSPATH')) {
    die('Direct access forbidden.');
}

/**
 * Class LSDP_Theme_Builder_Language_Map
 */
class LSDP_Theme_Builder_Language_Map
{

    /**
     * WordPress option key used to persist the template-to-language mapping.
     *
     * Stored as: array<int $template_id, string $lang_slug|'all'>
     */
    const OPTION_KEY = 'lsdp_tb_lang_map';

    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_admin_page'));
        add_action('admin_post_lsdp_save_tb_lang_map', array($this, 'save_lang_map'));
        add_filter('et_theme_builder_template_layouts', array($this, 'filter_layouts_by_lang'));
    }

    /**
     * Registers the "Theme Builder" submenu page under the Polylang (mlang) menu.
     */
    public function add_admin_page()
    {
        add_submenu_page(
            'mlang',
            esc_html__('Theme Builder Languages', 'language-switcher-for-divi-polylang'),
            esc_html__('Theme Builder', 'language-switcher-for-divi-polylang'),
            'manage_options',
            'lsdp-theme-builder',
            array($this, 'render_admin_page')
        );
    }

    /**
     * Renders the admin settings page.
     *
     * Lists all `et_template` (Divi Theme Builder template) posts and lets
     * the user assign a Polylang language (or "All Languages") to each one.
     */
    public function render_admin_page()
    {
        if (! current_user_can('manage_options')) {
            return;
        }

        // `et_template` is ET_THEME_BUILDER_TEMPLATE_POST_TYPE (defined by Divi).
        $templates = get_posts(
            array(
                'post_type'      => 'et_template',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => 'title',
                'order'          => 'ASC',
            )
        );

        $lang_map  = (array) get_option(self::OPTION_KEY, array());
        $languages = array();

        if (function_exists('pll_languages_list')) {
            $languages = pll_languages_list(array('fields' => ''));
        }
?>
        <div class="wrap">
            <h1><?php esc_html_e('Theme Builder — Language Conditions', 'language-switcher-for-divi-polylang'); ?></h1>
            <p>
                <?php
                esc_html_e(
                    'Assign a Polylang language to each Divi Theme Builder template. Templates set to "All Languages" use Divi\'s built-in display conditions and are unaffected by this mapping.',
                    'language-switcher-for-divi-polylang'
                );
                ?>
            </p>
            <p>
                <?php
                esc_html_e(
                    'Tip: you can also set per-language conditions directly in the Divi Theme Builder UI using the "Languages (Polylang)" condition group.',
                    'language-switcher-for-divi-polylang'
                );
                ?>
            </p>

            <?php if (isset($_GET['saved']) && '1' === $_GET['saved']) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended 
            ?>
                <div class="notice notice-success is-dismissible">
                    <p><?php esc_html_e('Language conditions saved.', 'language-switcher-for-divi-polylang'); ?></p>
                </div>
            <?php endif; ?>

            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('lsdp_tb_lang_map', 'lsdp_tb_nonce'); ?>
                <input type="hidden" name="action" value="lsdp_save_tb_lang_map">

                <table class="widefat striped" style="max-width:700px;margin-top:16px;">
                    <thead>
                        <tr>
                            <th><?php esc_html_e('Template Name', 'language-switcher-for-divi-polylang'); ?></th>
                            <th><?php esc_html_e('ID', 'language-switcher-for-divi-polylang'); ?></th>
                            <th><?php esc_html_e('Language', 'language-switcher-for-divi-polylang'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($templates)) : ?>
                            <tr>
                                <td colspan="3">
                                    <?php esc_html_e('No Theme Builder templates found. Create templates in Divi → Theme Builder first.', 'language-switcher-for-divi-polylang'); ?>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($templates as $template) : ?>
                                <?php
                                $template_id    = (int) $template->ID;
                                $assigned_lang  = isset($lang_map[$template_id]) ? $lang_map[$template_id] : 'all';
                                $template_title = $template->post_title ? $template->post_title : __('(no title)', 'language-switcher-for-divi-polylang');
                                ?>
                                <tr>
                                    <td><?php echo esc_html($template_title); ?></td>
                                    <td><?php echo esc_html($template_id); ?></td>
                                    <td>
                                        <select name="lsdp_tb_lang_map[<?php echo esc_attr($template_id); ?>]">
                                            <option value="all" <?php selected($assigned_lang, 'all'); ?>>
                                                <?php esc_html_e('All Languages', 'language-switcher-for-divi-polylang'); ?>
                                            </option>
                                            <?php foreach ((array) $languages as $lang) : ?>
                                                <?php if (is_object($lang) && isset($lang->slug, $lang->name)) : ?>
                                                    <option value="<?php echo esc_attr($lang->slug); ?>" <?php selected($assigned_lang, $lang->slug); ?>>
                                                        <?php echo esc_html($lang->name); ?>
                                                    </option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <?php if (! empty($templates)) : ?>
                    <p>
                        <?php
                        submit_button(
                            esc_html__('Save Language Conditions', 'language-switcher-for-divi-polylang'),
                            'primary',
                            'submit',
                            false
                        );
                        ?>
                    </p>
                <?php endif; ?>
            </form>
        </div>
<?php
    }

    /**
     * Handles form submission and persists the template-language mapping.
     */
    public function save_lang_map()
    {
        if (! current_user_can('manage_options')) {
            wp_die(esc_html__('Permission denied.', 'language-switcher-for-divi-polylang'));
        }

        if (
            ! isset($_POST['lsdp_tb_nonce']) ||
            ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['lsdp_tb_nonce'])), 'lsdp_tb_lang_map')
        ) {
            wp_die(esc_html__('Invalid nonce.', 'language-switcher-for-divi-polylang'));
        }

        $raw_map   = isset($_POST['lsdp_tb_lang_map']) ? (array) $_POST['lsdp_tb_lang_map'] : array();
        $clean_map = array();

        foreach ($raw_map as $template_id => $lang) {
            $clean_map[(int) $template_id] = sanitize_key($lang);
        }

        update_option(self::OPTION_KEY, $clean_map);

        wp_safe_redirect(
            add_query_arg('saved', '1', admin_url('admin.php?page=lsdp-theme-builder'))
        );
        exit;
    }

    /**
     * Clears the resolved template layouts when the winning template is assigned
     * to a specific language that does not match the current Polylang language.
     *
     * Hooked into `et_theme_builder_template_layouts` (Divi 4+), which fires
     * after Divi has resolved which template to apply for the current request.
     *
     * Returning an empty array causes Divi to skip all Theme Builder overrides
     * (header, body, footer) for this request, falling back to the standard
     * Divi/theme rendering. This is the desired behaviour when, for example,
     * an "Italian" template is matched but the visitor is browsing in English.
     *
     * Note: the template ID is only available for singular pages. For archives
     * and other non-singular requests Divi sets it to `false`, so this filter
     * does nothing and defers to the Theme Builder UI conditions.
     *
     * @param  array $layouts Resolved layout array keyed by Divi post type constants.
     * @return array Unchanged layouts, or an empty array when a language mismatch
     *               is detected.
     */
    public function filter_layouts_by_lang($layouts)
    {
        // Skip in the admin/builder and when Polylang is absent.
        if (! function_exists('pll_current_language') || is_admin()) {
            return $layouts;
        }

        if (empty($layouts)) {
            return $layouts;
        }

        $lang_map = (array) get_option(self::OPTION_KEY, array());

        if (empty($lang_map)) {
            return $layouts;
        }

        // For singular pages Divi stores the template ID; for archives it stores `false`.
        // ET_THEME_BUILDER_TEMPLATE_POST_TYPE = 'et_template' (Divi constant).
        $template_id = isset($layouts['et_template']) ? (int) $layouts['et_template'] : 0;

        // No template ID available (archive or no match) — do not interfere.
        if (! $template_id || ! isset($lang_map[$template_id])) {
            return $layouts;
        }

        $assigned     = $lang_map[$template_id];

        // Detect current language using the most reliable method available.
        // Modified 2026-05-22 by Marco Traina <https://www.trainaepartners.it>:
        // pll_get_post_language() / pll_get_term_language() are now preferred over
        // pll_current_language() to avoid false mismatches on Polylang free setups
        // (directory prefix, query string) where pll_current_language() may fire
        // before Polylang has fully resolved the current language for the request.
        // Same strategy used in lsdp_theme_builder_validate_polylang_language().
        $current_lang = '';
        $queried_id   = (int) get_queried_object_id();

        if ($queried_id > 0 && function_exists('pll_get_post_language')) {
            $current_lang = pll_get_post_language($queried_id);
        }

        if (empty($current_lang) && $queried_id > 0 && function_exists('pll_get_term_language')) {
            $current_lang = pll_get_term_language($queried_id);
        }

        if (empty($current_lang)) {
            $current_lang = pll_current_language();
        }

        // 'all' means no restriction; empty current lang means Polylang could not
        // determine the language (e.g. during REST requests) — keep layouts.
        if (empty($current_lang) || 'all' === $assigned) {
            return $layouts;
        }

        // Language mismatch: clear all layouts so Divi falls back to default rendering.
        if ($assigned !== $current_lang) {
            return array();
        }

        return $layouts;
    }
}
