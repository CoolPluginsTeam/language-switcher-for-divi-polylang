import React from 'react';

import { __ } from '@wordpress/i18n';

const {
  ColorPickerContainer,
  SelectContainer,
  RangeContainer,
 
} = window?.divi?.fieldLibrary;
const {
  FiltersGroup,
  FontGroup,
  GroupContainer,
  FieldContainer,
  SizingGroup,
  SpacingGroup,
} = window?.divi?.module;

const aspect_ratio = {
  'auto': __('Auto', 'connect-polylang-for-divi'),
  '1/1': __('1:1', 'connect-polylang-for-divi'),
  '4/3': __('4:3', 'connect-polylang-for-divi'),
};

/**
 * Design Settings panel for the Static Module.
 */
export const SettingsDesign = (props) => (
  <React.Fragment>
    <GroupContainer id="flag_style" title={__('Flag', 'connect-polylang-for-divi')}>
      <FieldContainer
        attrName="flag_style.decoration.aspect_ratio"
        label={__('Aspect Ratio', 'connect-polylang-for-divi')}
        subName="aspect_ratio"
        description={__('To apply aspect ratio for flag image.', 'connect-polylang-for-divi')}
        defaultValue={'auto'}
      >
        <SelectContainer options={Object.entries(aspect_ratio).reduce((acc, [key, label]) => {
          acc[key] = {
          label: __(label, 'connect-polylang-for-divi'),
          value: key,
          };
          return acc;
        }, {})}
        />
      </FieldContainer>

      <FieldContainer
        attrName="flag_style.decoration.flag_width"
        label={__('Flag Width', 'connect-polylang-for-divi')}
        subName="flag_width"
        description={__('To apply width for flag.', 'connect-polylang-for-divi')}
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
        label={__('Flag Border Radius', 'connect-polylang-for-divi')}
        subName="flag_border_radius"
        description={__('To apply border radius for flag.', 'connect-polylang-for-divi')}
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

    <GroupContainer id="text_style" title={__('Text', 'connect-polylang-for-divi')}>
    <FontGroup attrName="text_style.decoration.font"
        grouped={false}
        fields={{ textAlign: { render: false, }, }} />
    </GroupContainer>

    <GroupContainer id="background_style" title={__('Background', 'connect-polylang-for-divi')}>
      <FieldContainer
      attrName="background_style.decoration.background_color"
      label={__('Background Color', 'connect-polylang-for-divi')}
      subName="background_color"
      description={__('To apply background color.', 'connect-polylang-for-divi')}
      > 
      <ColorPickerContainer/>
      </FieldContainer>

      <SpacingGroup
        attrName="background_style.decoration.spacing"
        grouped={false}
      />
    </GroupContainer>

    <GroupContainer id="container_size" title={__('Sizing', 'connect-polylang-for-divi')}>
    <SizingGroup
      attrName="container_size.decoration.sizing"
      grouped={false}
    />
    </GroupContainer>

    <GroupContainer id="color_filters" title={__('Filters', 'connect-polylang-for-divi')}>
    <FiltersGroup
      attrName="color_filters.decoration.filters"
      grouped={false}
     />
    </GroupContainer>

  </React.Fragment>
);