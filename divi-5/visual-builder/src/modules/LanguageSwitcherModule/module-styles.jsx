import React from 'react';

const {
  StyleContainer,
  CommonStyle,
} = window?.divi?.module;

/**
 * Module style component for static module
 */
export const ModuleStyles = (props) => {
  const {
    attrs,
    elements,
    orderClass,
    mode,
    state,
    noStyleTag
  } = props;
  return (
    <StyleContainer mode={mode} state={state} noStyleTag={noStyleTag}>
      <CommonStyle
        selector={`${orderClass} .lsdp-wrapper.dropdown ul`}
        attr={attrs?.switcher_layouts}
        declarationFunction={(attrs) => {
          return `--lsdp-dropdown-index: 999;`;
        }}
      />
     <CommonStyle
        selector={`${orderClass} .lsdp-wrapper .lsdp-lang-image`}
        attr={attrs?.flag_style?.decoration?.aspect_ratio}
        declarationFunction={(attrs) => {
          const data = attrs.attrValue.aspect_ratio
          if(data === '1/1'){
            return (`--lsdp-flag-ratio: ${data}; --lsdp-flag-height: var(--lsdp-flag-width);`);
          }else{
            return (`--lsdp-flag-ratio: ${data}; --lsdp-flag-height: calc(var(--lsdp-flag-width) * 0.75);`);
          }
        }}
      />
        {((attrs?.flag_style?.decoration?.aspect_ratio?.desktop?.value?.aspect_ratio ?? attrs?.flag_style?.innerContent?.decoration?.aspect_ratio?.desktop?.value) === '1/1') ? (
          <>
          <CommonStyle
            selector={`${orderClass} .lsdp-wrapper .lsdp-lang-image`}
            attr={attrs?.flag_style?.decoration?.flag_width}
            declarationFunction={(attrs) => {
              const data = attrs.attrValue?.flag_width
              return (`--lsdp-flag-width: ${data}; --lsdp-flag-height: ${data};`);
            }}
          />
          </>
        ):(
          <CommonStyle
            selector={`${orderClass} .lsdp-wrapper .lsdp-lang-image`}
            attr={attrs?.flag_style?.decoration?.flag_width}
            declarationFunction={(attrs) => {
            const data = attrs?.attrValue?.flag_width
            return (`--lsdp-flag-width: ${data}; --lsdp-flag-height: calc(var(--lsdp-flag-width) * 0.75);`);
            }}
          />
        )}
     <CommonStyle
        selector={`${orderClass} .lsdp-wrapper .lsdp-lang-image`}
        attr={attrs?.flag_style?.decoration?.flag_border_radius}
        declarationFunction={(attrs) => {
        const data = attrs?.attrValue?.flag_border_radius
        return `--lsdp-flag-radius: ${data}`;
      }}
    />
    <CommonStyle
        selector={`${orderClass} .lsdp-wrapper ul li a, ${orderClass} .lsdp-wrapper.dropdown`}
        attr={attrs?.background_style?.decoration?.background_color}
        declarationFunction={(attrs) => {
        const data = attrs?.attrValue?.background_color
        return `background-color: ${data}`;
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