const convertInlineFont = (value) => (isString(value) ? value.split(',') : []);

export const conversionOutline = {
  advanced: {
    admin_label:    'module.meta.adminLabel',
    animation:      'module.decoration.animation',
    background:     'module.decoration.background',
    disabled_on:    'module.decoration.disabledOn',
    module:         'module.advanced.htmlAttributes',
    overflow:        'module.decoration.overflow',
    position_fields: 'module.decoration.position',
    scroll:         'module.decoration.scroll',
    sticky:         'module.decoration.sticky',
    text:           'module.advanced.text',
    transform:      'module.decoration.transform',
    transition:     'module.decoration.transition',
    z_index:        'module.decoration.zIndex',
    max_width:      'module.decoration.sizing',
    height:         'module.decoration.sizing',
    link_options:   'module.advanced.link',
    fonts:      {
      header:         'title.decoration.font',
      body:           'content.decoration.bodyFont.body',
      body_link:      'content.decoration.bodyFont.link',
      body_ul:        'content.decoration.bodyFont.ul',
      body_ol:        'content.decoration.bodyFont.ol',
      body_quote:     'content.decoration.bodyFont.quote',
      lsad_text_settings: 'text_style.decoration.font',
    },
    margin_padding: 'background_style.decoration.spacing',
    text_shadow:     {
      default: 'module.advanced.text.textShadow',
    },
    box_shadow: {
      default: 'module.decoration.boxShadow',
    },
    borders:        {
      default: 'module.decoration.border',
    },
    filters:   {
      default: 'module.decoration.filters',
    },
  },
  css: {
    after:        'css.*.after',
    before:       'css.*.before',
    main_element: 'css.*.mainElement',
    title:        'css.*.title',
    content:      'css.*.content',
  },
  module: {
    lsad_style:             'switcher_layouts.*.switcher_layouts',
    lsad_flag_visibility:   'show_language_flag.*.show_language_flag',
    lsad_language_name_visibility: 'show_language_name.*.show_language_name',
    lsad_language_code_visibility: 'show_language_code.*.show_language_code',
    lsad_current_lang_visibility:  'hide_current_language.*.hide_current_language',
    lsad_unstranslated_lang_visibility: 'hide_untranslated_language.*.hide_untranslated_language',
    lsad_flag_ratio: 'flag_style.decoration.aspect_ratio.*.aspect_ratio',
    lsad_flag_width: 'flag_style.decoration.flag_width.*.flag_width',
    lsad_flag_radius: 'flag_style.decoration.flag_border_radius.*.flag_border_radius',
    lsad_bg_normal_color: 'background_style.decoration.background_color.*.background_color',
  },
  valueExpansionFunctionMap: {
    inline_fonts: convertInlineFont
  },
};