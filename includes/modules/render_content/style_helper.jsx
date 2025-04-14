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
    const selector = '%%order_class%% .lsad-wrapper';

    const langPadding = props.lsad_bg_normal_padding ? props.lsad_bg_normal_padding : '';
    const langMargin = props.lsad_bg_normal_margin ? props.lsad_bg_normal_margin : '';
    const langNormalBgColor = props.lsad_bg_normal_color ? props.lsad_bg_normal_color : '';
    const langHoverBgColor = props.lsad_bg_hover_color ? props.lsad_bg_hover_color : '';
    const flagWidth = props.lsad_flag_width ? props.lsad_flag_width : '';
    const flagRadius = props.lsad_flag_radius ? props.lsad_flag_radius : '';
    const flagRatio = props.lsad_flag_ratio ? props.lsad_flag_ratio : '';
    const normalTextFont = props.lsad_normal_text_font ? props.lsad_normal_text_font : '';
    const normalTextColor = props.lsad_text_settings_text_color ? props.lsad_text_settings_text_color : '';
    const normalTextSize = props.lsad_normal_text_font_size ? props.lsad_normal_text_font_size : '';
    const normalTextLineHeight = props.lsad_normal_text_line_height ? props.lsad_normal_text_line_height : '';
    const hoverTextFont = props.lsad_hover_text_font ? props.lsad_hover_text_font : '';
    const hoverTextColor = props.lsad_hover_text_color ? props.lsad_hover_text_color : '';
    const hoverTextSize = props.lsad_hover_text_font_size ? props.lsad_hover_text_font_size : '';
    const hoverTextLineHeight = props.lsad_hover_text_line_height ? props.lsad_hover_text_line_height : '';

    if ('' !== langPadding) {
        const padding = getUnitValue(langPadding);
        Object.keys(padding).forEach((key) => {
            const value = padding[key];
            if ('' !== value) {
                customCss.push(
                    [
                        {
                            selector: selector,
                            declaration: `--lsad-lang-padding-${key}: ${value};`,
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
                            declaration: `--lsad-lang-margin-${key}: ${value};`,
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
                    declaration: `--lsad-normal-bg-color: ${langNormalBgColor};`,
                }
            ]
        );
    }

    if ('' !== langHoverBgColor) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-hover-bg-color: ${langHoverBgColor};`,
                }
            ]
        );
    }

    if ('' !== flagRatio && '1/1' === flagRatio) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-flag-height: var(--lsad-flag-width);`,
                }
            ]
        );
    } else if ('' !== flagRatio && '4/3' === flagRatio) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-flag-height: calc(var(--lsad-flag-width) * 0.75);`,
                }
            ]
        );
    }
    if ('' !== flagWidth) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-flag-width: ${flagWidth}`,
                }
            ]
        );
    }
    if ('' !== flagRadius) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-flag-radius: ${flagRadius}`,
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
                    declaration: `--lsad-normal-text-font: ${Font_properties['fontFamily']}`,
                }
            ]
        );
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-normal-text-weight: ${Font_properties['fontWeight']}`,
                }
            ]
        );
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-normal-text-transform: ${Font_properties['textTransform']}`,
                }
            ]
        );
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-normal-text-decoration: ${Font_properties['textDecoration']}`,
                }
            ]
        );
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-normal-text-style: ${Font_properties['fontStyle']}`,
                }
            ]
        );
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-normal-text-decoration-color: ${Font_properties['textDecorationLineColor']}`,
                }
            ]
        );
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-normal-text-decoration-style: ${Font_properties['textDecorationStyle']}`,
                }
            ]
        );
    }
    if ('' !== normalTextColor) {
        
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-normal-text-color: ${normalTextColor}`,
                }
            ]
        );
    }
    if ('' !== normalTextSize) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-normal-text-size: ${normalTextSize}`,
                }
            ]
        );
    }
    if ('' !== normalTextLineHeight) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-normal-text-line-height: ${normalTextLineHeight}`,
                }
            ]
        );
    }
    if ('' !== hoverTextFont) {
        const Font_properties = extractFontProperties(hoverTextFont);
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-hover-text-font: ${Font_properties['fontFamily']}`,
                }
            ]
        );
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-hover-text-weight: ${Font_properties['fontWeight']}`,
                }
            ]
        );
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-hover-text-transform: ${Font_properties['textTransform']}`,
                }
            ]
        );
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-hover-text-decoration: ${Font_properties['textDecoration']}`,
                }
            ]
        );
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-hover-text-style: ${Font_properties['fontStyle']}`,
                }
            ]
        );
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-hover-text-decoration-color: ${Font_properties['textDecorationLineColor']}`,
                }
            ]
        );
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-hover-text-decoration-style: ${Font_properties['textDecorationStyle']}`,
                }
            ]
        );
    }
    if ('' !== hoverTextColor) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-hover-text-color: ${hoverTextColor}`,
                }
            ]
        );
    }
    if ('' !== hoverTextSize) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-hover-text-size: ${hoverTextSize}`,
                }
            ]
        );
    }
    if ('' !== hoverTextLineHeight) {
        customCss.push(
            [
                {
                    selector: selector,
                    declaration: `--lsad-hover-text-line-height: ${hoverTextLineHeight}`,
                }
            ]
        );
    }


    return customCss;
};

export default staticCSS;