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

    {elements.style({
      attrName: 'text_style',
    })}

    {elements.style({
      attrName: 'background_style',
    })}

    {elements.style({
      attrName: 'sizing',
    })}

    {elements.style({
      attrName: 'filters',
    })}
    
    
  </StyleContainer>
);