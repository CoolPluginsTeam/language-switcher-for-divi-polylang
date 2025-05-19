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
  'auto': __('Auto', 'language-switcher-for-divi-polylang'),
  '1/1': __('1:1', 'language-switcher-for-divi-polylang'),
  '4/3': __('4:3', 'language-switcher-for-divi-polylang'),
};

/**
 * Design Settings panel for the Static Module.
 */
export const SettingsDesign = (props) => (
  <React.Fragment>
    <GroupContainer id="flag_style" title={__('Flag', 'language-switcher-for-divi-polylang')}>
      <FieldContainer
        attrName="flag_style.decoration.aspect_ratio"
        label={__('Aspect Ratio', 'language-switcher-for-divi-polylang')}
        subName="aspect_ratio"
        description={__('To apply aspect ratio for flag image.', 'language-switcher-for-divi-polylang')}
        defaultValue={'auto'}
      >
        <SelectContainer options={Object.entries(aspect_ratio).reduce((acc, [key, label]) => {
          acc[key] = {
          label: __(label, 'language-switcher-for-divi-polylang'),
          value: key,
          };
          return acc;
        }, {})}
        />
      </FieldContainer>

      <FieldContainer
        attrName="flag_style.decoration.flag_width"
        label={__('Flag Width', 'language-switcher-for-divi-polylang')}
        subName="flag_width"
        description={__('To apply width for flag.', 'language-switcher-for-divi-polylang')}
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
        label={__('Flag Border Radius', 'language-switcher-for-divi-polylang')}
        subName="flag_border_radius"
        description={__('To apply border radius for flag.', 'language-switcher-for-divi-polylang')}
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

    <GroupContainer id="text_style" title={__('Text', 'language-switcher-for-divi-polylang')}>
    <FontGroup attrName="text_style.decoration.font"
        grouped={false}
        fields={{ textAlign: { render: false, }, }} />
    </GroupContainer>

    <GroupContainer id="background_style" title={__('Background', 'language-switcher-for-divi-polylang')}>
      <FieldContainer
      attrName="background_style.decoration.background_color"
      label={__('Background Color', 'language-switcher-for-divi-polylang')}
      subName="background_color"
      description={__('To apply background color.', 'language-switcher-for-divi-polylang')}
      > 
      <ColorPickerContainer/>
      </FieldContainer>

      <SpacingGroup
        attrName="background_style.decoration.spacing"
        grouped={false}
      />
    </GroupContainer>

    <GroupContainer id="container_size" title={__('Sizing', 'language-switcher-for-divi-polylang')}>
    <SizingGroup
      attrName="container_size.decoration.sizing"
      grouped={false}
    />
    </GroupContainer>

    <GroupContainer id="color_filters" title={__('Filters', 'language-switcher-for-divi-polylang')}>
    <FiltersGroup
      attrName="color_filters.decoration.filters"
      grouped={false}
     />
    </GroupContainer>

  </React.Fragment>
);