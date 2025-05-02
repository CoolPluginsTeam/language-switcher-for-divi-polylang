const extractFontProperties = (fontString) => {
    const fontParts = fontString.split('|');
    const fontFamily = fontParts[0];
    const fontWeight = fontParts[1];
    const fontStyle = fontParts[2] === "on" ? "italic" : "normal";
    let textTransform = "none";
    let textDecoration = "none";

    // Determine text transform
    if (fontParts[3] === "on") {
        textTransform = "uppercase";
    } else if (fontParts[5] === "on") {
        textTransform = "capitalize";
    } else {
        textTransform = "none"
    }

    // Determine text decoration
    if (fontParts[4] === "on" && fontParts[6] === "on") {
        textDecoration = "line-through";
    } else if (fontParts[4] === "on") {
        textDecoration = "underline";
    } else if (fontParts[6] === "on") {
        textDecoration = "line-through";
    } else {
        textDecoration = "none"
    }

    const textDecorationLineColor = (fontParts[7] !== "") ? fontParts[7] : "";
    const textDecorationStyle = (fontParts[8] !== "") ? fontParts[8] : "";

    return {
        fontFamily,
        fontWeight,
        fontStyle,
        textTransform,
        textDecoration,
        textDecorationLineColor,
        textDecorationStyle
    };
}

const getUnitValue = (unitString) => {
    const units = unitString.split('|');
    return {
        'top': units[0],
        'bottom': units[2],
        'left': units[3],
        'right': units[1],
    };
}

const staticCSS = (props) => {
    const customCss = [];
    const selector = '%%order_class%% .cpfd-wrapper';

    const langPadding = props.cpfd_bg_normal_padding ? props.cpfd_bg_normal_padding : '';
    const langMargin = props.cpfd_bg_normal_margin ? props.cpfd_bg_normal_margin : '';
    const langNormalBgColor = props.cpfd_bg_normal_color ? props.cpfd_bg_normal_color : '';
    const langHoverBgColor = props.cpfd_bg_normal_color__hover ? props.cpfd_bg_normal_color__hover : '';
    const flagWidth = props.cpfd_flag_width ? props.cpfd_flag_width : '';
    const flagRadius = props.cpfd_flag_radius ? props.cpfd_flag_radius : '';
    const flagRatio = props.cpfd_flag_ratio ? props.cpfd_flag_ratio : '';
    const normalTextFont = props.cpfd_text_settings_font ? props.cpfd_text_settings_font : '';
    const normalTextColor = props.cpfd_text_settings_text_color ? props.cpfd_text_settings_text_color : '';
    const hoverTextColor = props.cpfd_text_settings_text_color__hover ? props.cpfd_text_settings_text_color__hover : '';
    const normalTextSize = props.cpfd_text_settings_font_size ? props.cpfd_text_settings_font_size : '';
    const hoverTextSize = props.cpfd_text_settings_font_size__hover ? props.cpfd_text_settings_font_size__hover : '';
    const normalTextLineHeight = props.cpfd_text_settings_line_height ? props.cpfd_text_settings_line_height : '';
    const hoverTextLineHeight = props.cpfd_text_settings_line_height__hover ? props.cpfd_text_settings_line_height__hover : '';
    const normal_text_spacing = props.cpfd_text_settings_letter_spacing ? props.cpfd_text_settings_letter_spacing : '';
    const hover_text_spacing = props.cpfd_text_settings_letter_spacing__hover ? props.cpfd_text_settings_letter_spacing__hover : '';
    const hover_bg_margin = props.custom_margin__hover ? props.custom_margin__hover : '';
    const hover_bg_padding = props.custom_padding__hover ? props.custom_padding__hover : '';
    customCss.push(
        [
            {
                selector: selector + '.dropdown',
                declaration: `--cpfd-dropdown-index: 999;`,
            }
        ]
    );

    if ('' !== langPadding) {
        const padding = getUnitValue(langPadding);
        Object.keys(padding).forEach((key) => {
            const value = padding[key];
            if ('' !== value) {
                customCss.push(
                    [
                        {
                            selector: selector,
                            declaration: `--cpfd-lang-padding-${key}: ${value};`,
                        }
                    ]
                );
            }
        })
    }

    if ('' !== langMargin) {
        const margin = getUnitValue(langMargin);
        Object.keys(margin).forEach((key) => {
            const value = margin[key];
            if ('' !== value) {
                customCss.push(
                    [
                        {
                            selector: selector,
                            declaration: `--cpfd-lang-margin-${key}: ${value};`,
                        }
                    ]
                );
            }
        })
    }

    if ('' !== langNormalBgColor) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--cpfd-normal-bg-color: ${langNormalBgColor};`,
                }
            ]
        );
    }
    
    if ('' !== langHoverBgColor) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--cpfd-hover-bg-color: ${langHoverBgColor};`,
                }
            ]
        );
    }

    if ('' !== hover_bg_margin) {
        const margin = getUnitValue(hover_bg_margin);
        Object.keys(margin).forEach((key) => {
            const value = margin[key];
            if ('' !== value) {
                customCss.push(
                    [
                        {
                            selector: selector,
                            declaration: `--cpfd-hover-bg-mrgn-${key}: ${value};`,
                        }
                    ]
                );
            }
        })
    }

    if ('' !== hover_bg_padding) {
        const padding = getUnitValue(hover_bg_padding);
        Object.keys(padding).forEach((key) => {
            const value = padding[key];
            if ('' !== value) {
                customCss.push(
                    [
                        {
                            selector: selector,
                            declaration: `--cpfd-hover-bg-pading-${key}: ${value};`,
                        }
                    ]
                );
            }
        })
    }   
    

    if ('' !== flagRatio && '1/1' === flagRatio) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--cpfd-flag-height: var(--cpfd-flag-width);`,
                }
            ]
        );
    } else if ('' !== flagRatio && '4/3' === flagRatio) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--cpfd-flag-height: calc(var(--cpfd-flag-width) * 0.75);`,
                }
            ]
        );
    }
    if ('' !== flagWidth) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--cpfd-flag-width: ${flagWidth}`,
                }
            ]
        );
    }
    if ('' !== flagRadius) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--cpfd-flag-radius: ${flagRadius}`,
                }
            ]
        );
    }
    if ('' !== normalTextFont) {
        const Font_properties = extractFontProperties(normalTextFont);
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--cpfd-normal-text-font: ${Font_properties['fontFamily']}`,
                }
            ]
        );
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--cpfd-normal-text-weight: ${Font_properties['fontWeight']}`,
                }
            ]
        );
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--cpfd-normal-text-transform: ${Font_properties['textTransform']}`,
                }
            ]
        );
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--cpfd-normal-text-decoration: ${Font_properties['textDecoration']}`,
                }
            ]
        );
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--cpfd-normal-text-style: ${Font_properties['fontStyle']}`,
                }
            ]
        );
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--cpfd-normal-text-decoration-color: ${Font_properties['textDecorationLineColor']}`,
                }
            ]
        );
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--cpfd-normal-text-decoration-style: ${Font_properties['textDecorationStyle']}`,
                }
            ]
        );
    }
    if ('' !== normalTextColor) {
        
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--cpfd-normal-text-color: ${normalTextColor}`,
                }
            ]
        );
    }
    if ('' !== hoverTextColor) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--cpfd-hover-text-color: ${hoverTextColor}`,
                }
            ]
        );
    }
    
    if ('' !== normalTextSize) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--cpfd-normal-text-size: ${normalTextSize}`,
                }
            ]
        );
    }
    if ('' !== hoverTextSize) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--cpfd-hover-text-size: ${hoverTextSize}`,
                }
            ]
        );
    }
    if ('' !== normalTextLineHeight) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--cpfd-normal-text-line-height: ${normalTextLineHeight}`,
                }
            ]
        );
    }
    if ('' !== hoverTextLineHeight) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--cpfd-hover-text-line-height: ${hoverTextLineHeight}`,
                }
            ]
        );
    }
    if ('' !== normal_text_spacing) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--cpfd-normal-text-letter-spacing: ${normal_text_spacing}`,
                }
            ]
        );
    }
    if ('' !== hover_text_spacing) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--cpfd-hover-text-letter-spacing: ${hover_text_spacing}`,
                }
            ]
        );
    }


    return customCss;
};

export default staticCSS;