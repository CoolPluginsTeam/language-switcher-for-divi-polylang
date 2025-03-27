import React from 'react';

import { __ } from '@wordpress/i18n';

const {
  AnimationGroup,
  BorderGroup,
  BoxShadowGroup,
  FiltersGroup,
  FontGroup,
  FontBodyGroup,
  SizingGroup,
  SpacingGroup,
  TextGroup,
  TransformGroup,
} = window?.divi?.module;


/**
 * Design Settings panel for the Static Module.
 */
export const SettingsDesign = ({ defaultSettingsAttrs }) => (
  <React.Fragment>
    <TextGroup
      defaultGroupAttr={defaultSettingsAttrs?.module?.advanced?.text}
    />
    <FontGroup
      attrName="title.decoration.font"
      groupLabel={__('Title Text', 'd5-tutorial-module-conversion')}
      fieldLabel={__('Title', 'd5-tutorial-module-conversion')}
      fields={{
        headingLevel: {
          render: true,
        },
      }}
      defaultGroupAttr={defaultSettingsAttrs?.title?.decoration?.font}
    />
    <FontBodyGroup
      attrName="content.decoration.bodyFont"
    />
    <SizingGroup />
    <SpacingGroup />
    <BorderGroup />
    <BoxShadowGroup />
    <FiltersGroup />
    <TransformGroup />
    <AnimationGroup />
  </React.Fragment>
);