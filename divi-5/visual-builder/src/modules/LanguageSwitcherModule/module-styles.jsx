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
        attr={attrs?.flag_style?.decoration?.aspect_ratio}
        declarationFunction={(attrs) => {
          const data = attrs.attrValue.aspect_ratio
          if(data === '1/1'){
            return (`--lsad-flag-ratio: ${data}; --lsad-flag-height: var(--lsad-flag-width);`);
          }else{
            return (`--lsad-flag-ratio: ${data}; --lsad-flag-height: calc(var(--lsad-flag-width) * 0.75);`);
          }
        }}
      />
        {((attrs?.flag_style?.decoration?.aspect_ratio?.desktop?.value?.aspect_ratio ?? attrs?.flag_style?.innerContent?.decoration?.aspect_ratio?.desktop?.value) === '1/1') ? (
          <>
          <CommonStyle
            selector={`${orderClass} .lsad-wrapper .lsad-lang-image`}
            attr={attrs?.flag_style?.decoration?.flag_width}
            declarationFunction={(attrs) => {
              const data = attrs.attrValue?.flag_width
              return (`--lsad-flag-width: ${data}; --lsad-flag-height: ${data};`);
            }}
          />
          </>
        ):(
          <CommonStyle
            selector={`${orderClass} .lsad-wrapper .lsad-lang-image`}
            attr={attrs?.flag_style?.decoration?.flag_width}
            declarationFunction={(attrs) => {
            const data = attrs?.attrValue?.flag_width
            return (`--lsad-flag-width: ${data}; --lsad-flag-height: calc(var(--lsad-flag-width) * 0.75);`);
            }}
          />
        )}
     <CommonStyle
        selector={`${orderClass} .lsad-wrapper .lsad-lang-image`}
        attr={attrs?.flag_style?.decoration?.flag_border_radius}
        declarationFunction={(attrs) => {
        const data = attrs?.attrValue?.flag_border_radius
        return `--lsad-flag-radius: ${data}`;
      }}
    />
        {console.log(attrs)}
    <CommonStyle
        selector={`${orderClass} .lsad-wrapper ul li, ${orderClass} .lsad-wrapper.dropdown`}
        attr={attrs?.background_style?.decoration?.background_color}
        declarationFunction={(attrs) => {
        const data = attrs?.attrValue?.background_color
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