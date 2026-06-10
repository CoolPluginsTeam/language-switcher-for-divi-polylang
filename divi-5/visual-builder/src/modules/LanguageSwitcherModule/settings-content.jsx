import React from 'react';

import { __ } from '@wordpress/i18n';

const {
  SelectContainer,
  ToggleContainer,
} = window?.divi?.fieldLibrary;
const { GroupContainer } = window?.divi?.modal;
const {
  FieldContainer,
} = window?.divi?.module;

const switcher_layouts = {
  'vertical': 'Vertical',
  'horizontal': 'Horizontal',
  'dropdown': 'Dropdown',
};

// Context to pass defaultSettingsAttrs down to EcmdFC without prop-drilling
const LSDPDSAContext = React.createContext(null);

const LSDPFC = ({ attrName, subName, children, defaultAttr: explicitDefaultAttr, ...rest }) => {
  const lsdpdsa = React.useContext(LSDPDSAContext);
  let computedDefaultAttr = explicitDefaultAttr;
  if (!computedDefaultAttr && lsdpdsa && attrName) {
    let raw = lsdpdsa?.[attrName]?.innerContent?.desktop?.value;
    if ((raw === undefined || raw === null) && attrName.includes('.')) {
      const rootKey = attrName.split('.')[0];
      raw = lsdpdsa?.[rootKey]?.innerContent?.desktop?.value;
    }
    if ((raw === undefined || raw === null) && subName) {
      raw = lsdpdsa?.[subName]?.innerContent?.desktop?.value;
    }
    if (raw !== undefined && raw !== null) {
      const scalar = (typeof raw === 'object' && !Array.isArray(raw))
        ? (subName ? raw[subName] : raw)
        : raw;
      computedDefaultAttr = subName
        ? { desktop: { value: { [subName]: scalar } } }
        : { desktop: { value: scalar } };
    }
  }
  return React.createElement(
    FieldContainer,
    { attrName, subName, defaultAttr: computedDefaultAttr, ...rest },
    children
  );
};

/**
 * Content Settings panel for the Static Module.
 */
export const SettingsContent = (props) => (
<LSDPDSAContext.Provider value={props.defaultSettingsAttrs}>
  <>
    <GroupContainer id="toggle_content" title={__("Language Switcher Settings", "lsdp")}>
        <>
          <LSDPFC
          attrName="switcher_layouts"
          subName="switcher_layouts"
          label={__('Layout Options', 'language-switcher-for-divi-polylang')}
          description={__('Select your switcher layout', 'language-switcher-for-divi-polylang')}
        >
          <SelectContainer
            options={Object.entries(switcher_layouts).reduce((acc, [key, label]) => {
              acc[key] = {
                label: __(label, 'language-switcher-for-divi-polylang'),
                value: key,
              };
              return acc;
            }, {})}
          />
        </LSDPFC>
      
        <LSDPFC
        attrName="show_language_flag"
        subName="show_language_flag"
        label="Show Language Flag"
        description="Show Language Flag"
      >
        <ToggleContainer />
      </LSDPFC>

      <LSDPFC
        attrName="show_language_name"
        subName="show_language_name"
        label="Show Language Name"
        description="Show Language Name"
      >
        <ToggleContainer />
      </LSDPFC>

      <LSDPFC
        attrName="show_language_code"
        subName="show_language_code"
        label="Show Language Code"
        description="Show Language Code"
      >
        <ToggleContainer />
      </LSDPFC>

      {((props?.attrs?.switcher_layouts?.desktop?.value?.switcher_layouts ?? props?.defaultSettingsAttrs?.switcher_layouts?.innerContent?.desktop?.value) !== 'dropdown') && (
      <LSDPFC
        attrName="hide_current_language"
        subName="hide_current_language"
        label="Hide Current Language"
        description="Hide Current Language"
      >
        <ToggleContainer />
      </LSDPFC>
      )}
      <LSDPFC
        attrName="hide_untranslated_language"
        subName="hide_untranslated_language"
        label="Hide Untranslated Languages"
        description="Hide Untranslated Languages"
      >
          <ToggleContainer />
        </LSDPFC>
        {((props?.attrs?.hide_untranslated_language?.desktop?.value?.hide_untranslated_language ?? props?.defaultSettingsAttrs?.hide_untranslated_language?.innerContent?.desktop?.value) === 'on') && (
        <div className="lsdp-settings-description" style={{color: 'red'}}><strong>Note:</strong> This setting only affects the frontend. Please check your site's frontend to see it in action.</div>
        )}
      </>
    </GroupContainer>
  </>
  </LSDPDSAContext.Provider>
);