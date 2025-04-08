/**
 * Retrieves attribute data values from the provided attributes object.
 *
 * @param {Object} attrs - The attributes object.
 * @return {Object} The processed attribute data values.
 */

export const getAttrDataValues = (attrs) => {
    const isEmpty = (value) => {
      return value === undefined || value === null || value === '';
    };
  
    const getAttrValue = (path, defaultValue, attrName) => {
      return !isEmpty(path?.desktop?.value?.[attrName])
        ? path.desktop.value[attrName]
        : defaultValue;
    };
    return {
        show_language_switcher: getAttrValue(attrs?.show_language_switcher, 'on', 'show_language_switcher'),
        switcher_layouts: getAttrValue(attrs?.switcher_layouts, 'horizontal', 'switcher_layouts'),
        show_language_flag: getAttrValue(attrs?.show_language_flag, 'on', 'show_language_flag'),
        show_language_name: getAttrValue(attrs?.show_language_name, 'on', 'show_language_name'),
        show_language_code: getAttrValue(attrs?.show_language_code, 'off', 'show_language_code'),
        hide_current_language: getAttrValue(attrs?.hide_current_language, 'off', 'hide_current_language'),
        hide_untranslated_language: getAttrValue(attrs?.hide_untranslated_language, 'off', 'hide_untranslated_language'),
    };  
}
