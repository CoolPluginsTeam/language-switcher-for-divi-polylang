import React from 'react';

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
        selector={`${orderClass} .cpfd-wrapper.dropdown ul`}
        attr={attrs?.switcher_layouts}
        declarationFunction={(attrs) => {
          return `--cpfd-dropdown-index: 99`;
        }}
      />
     <CommonStyle
        selector={`${orderClass} .cpfd-wrapper .cpfd-lang-image`}
        attr={attrs?.flag_style?.decoration?.aspect_ratio}
        declarationFunction={(attrs) => {
          const data = attrs.attrValue.aspect_ratio
          if(data === '1/1'){
            return (`--cpfd-flag-ratio: ${data}; --cpfd-flag-height: var(--cpfd-flag-width);`);
          }else{
            return (`--cpfd-flag-ratio: ${data}; --cpfd-flag-height: calc(var(--cpfd-flag-width) * 0.75);`);
          }
        }}
      />
        {((attrs?.flag_style?.decoration?.aspect_ratio?.desktop?.value?.aspect_ratio ?? attrs?.flag_style?.innerContent?.decoration?.aspect_ratio?.desktop?.value) === '1/1') ? (
          <>
          <CommonStyle
            selector={`${orderClass} .cpfd-wrapper .cpfd-lang-image`}
            attr={attrs?.flag_style?.decoration?.flag_width}
            declarationFunction={(attrs) => {
              const data = attrs.attrValue?.flag_width
              return (`--cpfd-flag-width: ${data}; --cpfd-flag-height: ${data};`);
            }}
          />
          </>
        ):(
          <CommonStyle
            selector={`${orderClass} .cpfd-wrapper .cpfd-lang-image`}
            attr={attrs?.flag_style?.decoration?.flag_width}
            declarationFunction={(attrs) => {
            const data = attrs?.attrValue?.flag_width
            return (`--cpfd-flag-width: ${data}; --cpfd-flag-height: calc(var(--cpfd-flag-width) * 0.75);`);
            }}
          />
        )}
     <CommonStyle
        selector={`${orderClass} .cpfd-wrapper .cpfd-lang-image`}
        attr={attrs?.flag_style?.decoration?.flag_border_radius}
        declarationFunction={(attrs) => {
        const data = attrs?.attrValue?.flag_border_radius
        return `--cpfd-flag-radius: ${data}`;
      }}
    />
    <CommonStyle
        selector={`${orderClass} .cpfd-wrapper ul li, ${orderClass} .cpfd-wrapper.dropdown`}
        attr={attrs?.background_style?.decoration?.background_color}
        declarationFunction={(attrs) => {
        const data = attrs?.attrValue?.background_color
        return `--cpfd-normal-bg-color: ${data} !important`;
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