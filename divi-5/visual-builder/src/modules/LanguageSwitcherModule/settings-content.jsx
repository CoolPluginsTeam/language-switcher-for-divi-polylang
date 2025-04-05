import React from 'react';

import { __ } from '@wordpress/i18n';

const {
  RichTextContainer,
  TextContainer,
  SelectContainer,
  ToggleContainer,
} = window?.divi?.fieldLibrary;
const { GroupContainer } = window?.divi?.modal;
const {
  AdminLabelGroup,
  BackgroundGroup,
  FieldContainer,
  LinkGroup,
} = window?.divi?.module;

const switcher_layouts = {
  'vertical': 'Vertical',
  'horizontal': 'Horizontal',
  'dropdown': 'Dropdown',
};

/**
 * Content Settings panel for the Static Module.
 */
export const SettingsContent = (props) => (

  <>
    <GroupContainer id="toggle_content" title={__("Language Switcher Settings", "language-switcher-addon-for-divi")}>
      <FieldContainer
        attrName="show_language_switcher"
        subName="show_language_switcher"
        label="Show Language Switcher"
        description="Show Language Switcher"
        defaultValue='on'
      >
        <ToggleContainer />
      </FieldContainer>
      {((props?.attrs?.show_language_switcher?.desktop?.value?.show_language_switcher ?? props?.defaultSettingsAttrs?.show_language_switcher?.innerContent?.desktop?.value) === 'on') && (
        <>
          <FieldContainer
            attrName="switcher_layouts"
          subName="switcher_layouts"
          label={__('Layout Options', 'language-switcher-addon-for-divi')}
          description={__('Select your switcher layout', 'language-switcher-addon-for-divi')}
          defaultValue={'vertical'}
        >
          <SelectContainer
            options={Object.entries(switcher_layouts).reduce((acc, [key, label]) => {
              acc[key] = {
                label: __(label, 'ecmd-events-calendar-modules-for-divi-pro'),
                value: key,
              };
              return acc;
            }, {})}
          />
        </FieldContainer>
      
        <FieldContainer
        attrName="show_language_flag"
        subName="show_language_flag"
        label="Show Language Flag"
        description="Show Language Flag"
        defaultValue='on'
      >
        <ToggleContainer />
      </FieldContainer>

      <FieldContainer
        attrName="show_language_name"
        subName="show_language_name"
        label="Show Language Name"
        description="Show Language Name"
        defaultValue='on'
      >
        <ToggleContainer />
      </FieldContainer>

      <FieldContainer
        attrName="show_language_code"
        subName="show_language_code"
        label="Show Language Code"
        description="Show Language Code"
        defaultValue='off'
      >
        <ToggleContainer />
      </FieldContainer>

      {((props?.attrs?.switcher_layouts?.desktop?.value?.switcher_layouts ?? props?.defaultSettingsAttrs?.switcher_layouts?.innerContent?.desktop?.value) !== 'dropdown') && (
      <FieldContainer
        attrName="hide_current_language"
        subName="hide_current_language"
        label="Hide Current Language"
        description="Hide Current Language"
        defaultValue='off'
      >
        <ToggleContainer />
      </FieldContainer>
      )}
      <FieldContainer
        attrName="hide_untranslated_language"
        subName="hide_untranslated_language"
        label="Hide Untranslated Languages"
        description="Hide Untranslated Languages"
        defaultValue='off'
      >
          <ToggleContainer />
        </FieldContainer>
      </>
      )}
      
    </GroupContainer>
  </>
);