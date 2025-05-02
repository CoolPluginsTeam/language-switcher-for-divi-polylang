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
            if ($current_lang === $lang['slug'] || ($lang['no_translation'] && $props['hide_untranslated_language'] === 'on')) {
                continue;
            }

            $flag_icon = \CPFD_HELPERS::get_country_flag($lang['flag'], $lang['name']);

            $languages_html .= '<li class="cpfd-lang-item" style="z-index: 999;">';
            $languages_html .= '<a href="' . esc_url($lang['url']) . '">';
            if (!empty($props['show_language_flag']) && $props['show_language_flag'] === 'on') {
                $languages_html .= '<div class="cpfd-lang-image">' . $flag_icon . '</div>';
            }
            if (!empty($props['show_language_name']) && $props['show_language_name'] === 'on') {
                $languages_html .= '<div class="cpfd-lang-name">' . esc_html($lang['name']) . '</div>';
            }
            if (!empty($props['show_language_code']) && $props['show_language_code'] === 'on') {
                $languages_html .= '<div class="cpfd-lang-code">' . esc_html($lang['slug']) . '</div>';
            }
            $languages_html .= '</a></li>';
        }
        
        return $active_html . '<ul class="cpfd-language-list" style="z-index: 999;">' . $languages_html . '</ul>';
    }

    private static function get_active_language_html($lang, $props)
    {
        $html = '<span class="cpfd-active-language">';
        $html .= '<a href="' . esc_url($lang['url']) . '">';
        if (!empty($props['show_language_flag']) && $props['show_language_flag'] === 'on') {
            $html .= '<div class="cpfd-lang-image">' . \CPFD_HELPERS::get_country_flag($lang['flag'], $lang['name']) . '</div>';
        }
        if (!empty($props['show_language_name']) && $props['show_language_name'] === 'on') {
            $html .= '<div class="cpfd-lang-name">' . esc_html($lang['name']) . '</div>';
        }
        if (!empty($props['show_language_code']) && $props['show_language_code'] === 'on') {
            $html .= '<div class="cpfd-lang-code">' . esc_html($lang['slug']) . '</div>';
        }
        $html .= '</a></span>';
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

            $html .= '<li class="cpfd-lang-item" style="z-index: 999;">';
            $html .= $anchor_open;
            if ($props['show_language_flag'] === 'on') {
                $html .= '<div class="cpfd-lang-image">' .$flag_icon .'</div>';
            }
            if ($props['show_language_name'] === 'on') {
                $html .= '<div class="cpfd-lang-name">' . wp_kses_post(esc_html($lang['name'])) . '</div>';
            }
            if ($props['show_language_code'] === 'on') {
                $html .= '<div class="cpfd-lang-code">' . wp_kses_post(esc_html($lang['slug'])) . '</div>';
            }
            $html .= $anchor_close;
            $html .= '</li>';
        }
        return '<ul class="cpfd-language-list" style="z-index: 999;">' . $html . '</ul>';
    }

    public static function render_content($props)
    {
        return self::cpfd_render_content($props);
    }
}
