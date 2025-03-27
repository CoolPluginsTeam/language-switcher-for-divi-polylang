import React from 'react';

import { cssFields } from './custom-css';

const {
  CssStyle,
  StyleContainer,
  TextStyle,
} = window?.divi?.module;

/**
 * Module style component for static module
 */
export const ModuleStyles = ({
  attrs,
  elements,
  settings,
  orderClass,
  mode,
  state,
  noStyleTag
}) => (
  <StyleContainer mode={mode} state={state} noStyleTag={noStyleTag}>
    {/* Element: Module */}
    {elements.style({
      attrName:   'module',
      styleProps: {
        disabledOn: {
          disabledModuleVisibility: settings?.disabledModuleVisibility,
        },
      },
    })}
    <CssStyle
      selector={orderClass}
      attr={attrs.css}
      cssFields={cssFields}
    />
    <TextStyle
      selector={`${orderClass} .dtmc_static_module_content`}
      attr={attrs?.module?.advanced?.text}
      propertySelectors={{
        textShadow: {
          desktop: {
            value: {
              'text-shadow': `${orderClass} .dtmc_static_module_content`,
            },
          },
        },
      }}
    />

    {/* Element: Title */}
    {elements.style({
      attrName: 'title',
    })}

    {/* Element: Content */}
    {elements.style({
      attrName: 'content',
    })}
  </StyleContainer>
);