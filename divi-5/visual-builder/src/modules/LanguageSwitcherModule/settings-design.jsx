import React from 'react';

import { __ } from '@wordpress/i18n';

const {
  ColorPickerContainer,
  SelectContainer,
  RangeContainer,
  SpacingContainer,
 
} = window?.divi?.fieldLibrary;
const {
  AnimationGroup,
  BorderGroup,
  BoxShadowGroup,
  FiltersGroup,
  FontGroup,
  FontBodyGroup,
  GroupContainer,
  FieldContainer,
  SizingGroup,
  SpacingGroup,
  TextGroup,
  TransformGroup,
} = window?.divi?.module;

const aspect_ratio = {
  'auto': __('Auto', 'language-switcher-addon-for-divi'),
  '1/1': __('1:1', 'language-switcher-addon-for-divi'),
  '4/3': __('4:3', 'language-switcher-addon-for-divi'),
};

/**
 * Design Settings panel for the Static Module.
 */
export const SettingsDesign = (props) => (
  <React.Fragment>
    <GroupContainer id="flag_style" title={__('Flag', 'language-switcher-addon-for-divi')}>
      <FieldContainer
        attrName="aspect_ratio"
        label={__('Aspect Ratio', 'language-switcher-addon-for-divi')}
        subName="aspect_ratio"
        description={__('To apply aspect ratio for flag image.', 'language-switcher-addon-for-divi')}
        defaultValue={'auto'}
      >
        <SelectContainer options={Object.entries(aspect_ratio).reduce((acc, [key, label]) => {
          acc[key] = {
          label: __(label, 'language-switcher-addon-for-divi'),
          value: key,
          };
          return acc;
        }, {})}
        />
      </FieldContainer>

      <FieldContainer
        attrName="flag_width"
        label={__('Flag Width', 'language-switcher-addon-for-divi')}
        subName="flag_width"
        description={__('To apply width for flag.', 'language-switcher-addon-for-divi')}
        defaultValue={'20'}
      >
        <RangeContainer
          defaultUnit="px"
          min={0}
          max={100}
          step={1}
        />
      </FieldContainer>

      <FieldContainer
        attrName="flag_border_radius"
        label={__('Flag Border Radius', 'language-switcher-addon-for-divi')}
        subName="flag_border_radius"
        description={__('To apply border radius for flag.', 'language-switcher-addon-for-divi')}
        defaultValue={'0'}
      >
        <RangeContainer
          defaultUnit="px"
          min={0}
          max={100}
          step={1}
        />
      </FieldContainer>
    </GroupContainer>

    <GroupContainer id="text_style" title={__('Text', 'language-switcher-addon-for-divi')}>
    <FontGroup attrName="text_style.decoration.font"
        grouped={false}
        fields={{ textAlign: { render: false, }, }} />
    </GroupContainer>

    <GroupContainer id="background_style" title={__('Background', 'language-switcher-addon-for-divi')}>
      <FieldContainer
      attrName="background_style.decoration.color"
      label={__('Background Color', 'language-switcher-addon-for-divi')}
      subName="background_style.decoration.color"
      description={__('To apply background color.', 'language-switcher-addon-for-divi')}
      > 
      <ColorPickerContainer/>
      </FieldContainer>

      <SpacingGroup
        attrName="background_style.decoration.spacing"
        grouped={false}
      />
    </GroupContainer>

    <GroupContainer id="container_size" title={__('Sizing', 'language-switcher-addon-for-divi')}>
    <SizingGroup
      attrName="container_size.decoration.sizing"
      grouped={false}
    />
    </GroupContainer>

    <GroupContainer id="color_filters" title={__('Filters', 'language-switcher-addon-for-divi')}>
    <FiltersGroup
      attrName="color_filters.decoration.filters"
      grouped={false}
     />
    </GroupContainer>

  </React.Fragment>
);