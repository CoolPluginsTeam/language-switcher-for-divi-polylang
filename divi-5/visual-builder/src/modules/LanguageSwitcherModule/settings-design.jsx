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
  'auto': __('Auto', 'cpfd'),
  '1/1': __('1:1', 'cpfd'),
  '4/3': __('4:3', 'cpfd'),
};

/**
 * Design Settings panel for the Static Module.
 */
export const SettingsDesign = (props) => (
  <React.Fragment>
    <GroupContainer id="flag_style" title={__('Flag', 'cpfd')}>
      <FieldContainer
        attrName="flag_style.decoration.aspect_ratio"
        label={__('Aspect Ratio', 'cpfd')}
        subName="aspect_ratio"
        description={__('To apply aspect ratio for flag image.', 'cpfd')}
        defaultValue={'auto'}
      >
        <SelectContainer options={Object.entries(aspect_ratio).reduce((acc, [key, label]) => {
          acc[key] = {
          label: __(label, 'cpfd'),
          value: key,
          };
          return acc;
        }, {})}
        />
      </FieldContainer>

      <FieldContainer
        attrName="flag_style.decoration.flag_width"
        label={__('Flag Width', 'cpfd')}
        subName="flag_width"
        description={__('To apply width for flag.', 'cpfd')}
        defaultValue={20}
      >
        <RangeContainer
          defaultUnit="px"
          min={0}
          max={100}
          step={1}
        />
      </FieldContainer>

      <FieldContainer
        attrName="flag_style.decoration.flag_border_radius"
        label={__('Flag Border Radius', 'cpfd')}
        subName="flag_border_radius"
        description={__('To apply border radius for flag.', 'cpfd')}
        defaultValue={0}
      >
        <RangeContainer
          defaultUnit="px"
          min={0}
          max={100}
          step={1}
        />
      </FieldContainer>
    </GroupContainer>

    <GroupContainer id="text_style" title={__('Text', 'cpfd')}>
    <FontGroup attrName="text_style.decoration.font"
        grouped={false}
        fields={{ textAlign: { render: false, }, }} />
    </GroupContainer>

    <GroupContainer id="background_style" title={__('Background', 'cpfd')}>
      <FieldContainer
      attrName="background_style.decoration.background_color"
      label={__('Background Color', 'cpfd')}
      subName="background_color"
      description={__('To apply background color.', 'cpfd')}
      > 
      <ColorPickerContainer/>
      </FieldContainer>

      <SpacingGroup
        attrName="background_style.decoration.spacing"
        grouped={false}
      />
    </GroupContainer>

    <GroupContainer id="container_size" title={__('Sizing', 'cpfd')}>
    <SizingGroup
      attrName="container_size.decoration.sizing"
      grouped={false}
    />
    </GroupContainer>

    <GroupContainer id="color_filters" title={__('Filters', 'cpfd')}>
    <FiltersGroup
      attrName="color_filters.decoration.filters"
      grouped={false}
     />
    </GroupContainer>

  </React.Fragment>
);