<?php

namespace LSDP\Modules\LanguageSwitcherModule\LanguageSwitcherModuleTraits;

require_once LSDP_DIR . 'helpers/class-lsdp-helpers.php';

if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

trait RenderContentTrait
{

    private static function render_language_items($languages, $current_lang, $props, $is_dropdown)
    {
        $html = '';
        foreach ($languages as $lang) {
            $hide_untranslated = $lang['no_translation'] && $props['hide_untranslated_language'] === 'on';
            
            if ($is_dropdown) {
                if ($current_lang === $lang['slug'] || $hide_untranslated) {
                    continue;
                }
            } else {
                $hide_current = $current_lang === $lang['slug'] && $props['hide_current_language'] === 'on';
                if ($hide_current || $hide_untranslated) {
                    continue;
                }
            }

            $html .= '<li class="lsdp-lang-item">';
            $html .= '<a href="' . esc_url($lang['url']) . '">';
            $html .= \LSDP_HELPERS::build_language_item($lang, $props);
            $html .= '</a></li>';
        }
        return $html;
    }

    private static function get_dropdown_languages_html($languages, $current_lang, $props)
    {
        $active_html = self::get_active_language_html($languages[$current_lang], $props);
        $languages_html = self::render_language_items($languages, $current_lang, $props, true);
        
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
        $languages_html = self::render_language_items($languages, $current_lang, $props, false);
        return '<ul class="lsdp-language-list">' . $languages_html . '</ul>';
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
