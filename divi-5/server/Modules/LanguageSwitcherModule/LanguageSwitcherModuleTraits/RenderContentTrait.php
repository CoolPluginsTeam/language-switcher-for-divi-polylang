<?php

namespace LSDP\Modules\LanguageSwitcherModule\LanguageSwitcherModuleTraits;

require_once LSDP_DIR . 'helpers/class-lsdp-helpers.php';

if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

trait RenderContentTrait
{

    private static function get_dropdown_languages_html($languages, $current_lang, $props)
    {
        $active_html = self::get_active_language_html($languages[$current_lang], $props);
        $languages_html = '';
        
        foreach ($languages as $lang) {
            if ($current_lang === $lang['slug'] || ($lang['no_translation'] && $props['hide_untranslated_language'] === 'on')) {
                continue;
            }

            $languages_html .= '<li class="lsdp-lang-item">';
            $languages_html .= '<a href="' . esc_url($lang['url']) . '">';
            $languages_html .= \LSDP_HELPERS::build_language_item($lang, $props);
            $languages_html .= '</a></li>';
        }
        
        return $active_html . '<ul class="lsdp-language-list">' . $languages_html . '</ul>';
    }

    private static function get_active_language_html($lang, $props)
    {
        $html = '<span class="lsdp-active-language">';
        $html .= '<a href="' . esc_url($lang['url']) . '">';
        $html .= \LSDP_HELPERS::build_language_item($lang, $props);
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

            $anchor_open = '<a href="' . esc_url($lang['url']) . '">';
            $anchor_close = '</a>';

            $html .= '<li class="lsdp-lang-item">';
            $html .= $anchor_open;
            $html .= \LSDP_HELPERS::build_language_item($lang, $props);
            $html .= $anchor_close;
            $html .= '</li>';
        }
        return '<ul class="lsdp-language-list">' . $html . '</ul>';
    }

    public static function render_content($props)
    {
        $languages = \LSDP_HELPERS::get_languages();
        $current_lang = \LSDP_HELPERS::get_current_language();
        
        if (!$languages || !isset($languages[$current_lang])) {
            return '';
        }
        
        if ($props['switcher_layouts'] === 'dropdown') {
            return self::get_dropdown_languages_html($languages, $current_lang, $props);
        }
        
        return self::get_languages_list_html($languages, $current_lang, $props);
    }
}
