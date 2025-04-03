import React from 'react';

import { cssFields } from './custom-css';

const {
  CssStyle,
  StyleContainer,
  CommonStyle,
  TextStyle,
} = window?.divi?.module;

/**
 * Module style component for static module
 */
export const ModuleStyles = (props) => {
  const {
    attrs,
    elements,
    settings,
    orderClass,
    mode,
    state,
    noStyleTag
  } = props;
  return (
    <StyleContainer mode={mode} state={state} noStyleTag={noStyleTag}>
      <CommonStyle
        selector={`${orderClass} .lsad-wrapper .lsad-lang-image`}
        attr={attrs?.aspect_ratio}
        declarationFunction={(attrs) => {
        const data = attrs?.attrValue?.aspect_ratio
        return `--lsad-flag-ratio: ${data}`;
      }}
    />

      <CommonStyle
        selector={`${orderClass} .lsad-wrapper .lsad-lang-image`}
        attr={attrs?.flag_width}
        declarationFunction={(attrs) => {
        const data = attrs?.attrValue?.flag_width
        return `--lsad-flag-width: ${data}`;
      }}
    />
     <CommonStyle
        selector={`${orderClass} .lsad-wrapper .lsad-lang-image`}
        attr={attrs?.flag_border_radius}
        declarationFunction={(attrs) => {
        const data = attrs?.attrValue?.flag_border_radius
        return `--lsad-flag-radius: ${data}`;
      }}
    />
    <CommonStyle
        selector={`${orderClass} .lsad-wrapper ul, ${orderClass} .lsad-wrapper.dropdown`}
        attr={attrs?.background_style?.decoration?.color}
        declarationFunction={(attrs) => {
        const data = attrs?.attrValue?.background_style?.decoration?.color
        return `--lsad-normal-bg-color: ${data} !important`;
      }}
    />
    {elements.style({
      attrName: 'text_style',
    })}

    {elements.style({
      attrName: 'background_style',
    })}

    {elements.style({
      attrName: 'container_size',
    })}
    {elements.style({
      attrName: 'flag_style',
    })}

    {elements.style({
      attrName: 'color_filters',
    })}
    
    </StyleContainer>
  );
};