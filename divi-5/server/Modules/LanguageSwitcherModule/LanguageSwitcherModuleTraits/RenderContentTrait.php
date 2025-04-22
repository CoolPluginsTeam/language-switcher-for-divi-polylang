<?php

namespace CPFD\Modules\LanguageSwitcherModule\LanguageSwitcherModuleTraits;

require_once CPFD_DIR . 'helpers/class-cpfd-helpers.php';

if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

trait RenderContentTrait
{
    public static function cpfd_render_content($props)
    {
        global $polylang;
        
        $languages = pll_the_languages(['raw' => 1]);
        $current_lang = strtolower(pll_current_language());
        
        if (!$languages || !isset($languages[$current_lang])) {
            return '';
        }
        
        if ($props['switcher_layouts'] === 'dropdown') {
            return self::get_dropdown_languages_html($languages, $current_lang, $props);
        }
        
        return self::get_languages_list_html($languages, $current_lang, $props);
    }

    private static function get_dropdown_languages_html($languages, $current_lang, $props)
    {
        $active_html = self::get_active_language_html($languages[$current_lang], $props);
        $languages_html = '';
        
        foreach ($languages as $lang) {
            // var_dump($lang);
            if ($current_lang === $lang['slug'] || ($lang['no_translation'] && $props['hide_untranslated_language'] === 'on')) {
                continue;
            }

            $flag_icon = \CPFD_HELPERS::get_country_flag($lang['flag'], $lang['name']);
            $anchor_open = '<a href="' . esc_url($lang['url']) . '">';
            $anchor_close = '</a>';

            $languages_html .= '<li class="cpfd-lang-item">';
            if ($props['show_language_flag'] === 'on') {
                $languages_html .= '<div class="cpfd-lang-image">' . wp_kses_post($anchor_open) . $flag_icon . wp_kses_post($anchor_close) . '</div>';
            }
            if ($props['show_language_name'] === 'on') {
                $languages_html .= '<div class="cpfd-lang-name">' . wp_kses_post($anchor_open . esc_html($lang['name']) . $anchor_close) . '</div>';
            }
            if ($props['show_language_code'] === 'on') {
                $languages_html .= '<div class="cpfd-lang-code">' . wp_kses_post($anchor_open . esc_html($lang['slug']) . $anchor_close) . '</div>';
            }
            $languages_html .= '</li>';
        }
        
        return $active_html . '<ul class="cpfd-language-list">' . $languages_html . '</ul></div>';
    }

    private static function get_active_language_html($lang, $props)
    {
        $html = '<span class="cpfd-active-language">';
        if ($props['show_language_flag'] === 'on') {
            $html .= '<div class="cpfd-lang-image"><a href="' . esc_url($lang['url']) . '">' . \CPFD_HELPERS::get_country_flag($lang['flag'], $lang['name']) . '</a></div>';
        }
        if ($props['show_language_name'] === 'on') {
            $html .= '<div class="cpfd-lang-name"><a href="' . esc_url($lang['url']) . '">' . esc_html($lang['name']) . '</a></div>';
        }
        if ($props['show_language_code'] === 'on') {
            $html .= '<div class="cpfd-lang-code"><a href="' . esc_url($lang['url']) . '">' . esc_html($lang['slug']) . '</a></div>';
        }
        $html .= '</span>';
        return $html;
    }

    private static function get_languages_list_html($languages, $current_lang, $props)
    {
        $html = '';
        foreach ($languages as $lang) {
            if (($current_lang === $lang['slug'] && $props['hide_current_language'] === 'on') ||
                ($lang['no_translation'] && $props['hide_untranslated_language'] === 'on')) {
                continue;
            }

            $flag_icon = \CPFD_HELPERS::get_country_flag($lang['flag'], $lang['name']);
            $anchor_open = '<a href="' . esc_url($lang['url']) . '">';
            $anchor_close = '</a>';

            $html .= '<li class="cpfd-lang-item">';
            if ($props['show_language_flag'] === 'on') {
                $html .= '<div class="cpfd-lang-image">' . wp_kses_post($anchor_open) . $flag_icon . wp_kses_post($anchor_close) . '</div>';
            }
            if ($props['show_language_name'] === 'on') {
                $html .= '<div class="cpfd-lang-name">' . wp_kses_post($anchor_open . esc_html($lang['name']) . $anchor_close) . '</div>';
            }
            if ($props['show_language_code'] === 'on') {
                $html .= '<div class="cpfd-lang-code">' . wp_kses_post($anchor_open . esc_html($lang['slug']) . $anchor_close) . '</div>';
            }
            $html .= '</li>';
        }
        return '<ul class="cpfd-language-list">' . $html . '</ul>';
    }

    public static function render_content($props)
    {
        return self::cpfd_render_content($props);
    }
}
