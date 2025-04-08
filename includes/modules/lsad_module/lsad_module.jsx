// External Dependencies
import React, { Component } from 'react';
import { CountryFlag, CountryName, CountryCode, staticCSS } from '../render_content';

// Internal Dependencies
import './style.css';

class LSAD_Module extends Component {

  static slug = 'language-switcher-addon-for-divi';

  constructor(props) {
    super(props);
    this.state = {
      languageData: null,
      currentLang: null
    };
  }

  componentDidMount() {
    setTimeout(() => {
      const polylangData =window.ETBuilderBackendDynamic &&  window.ETBuilderBackendDynamic.lsadGlobalObj &&  window.ETBuilderBackendDynamic.lsadGlobalObj.lsadLanguangeData ? window.ETBuilderBackendDynamic.lsadGlobalObj.lsadLanguangeData : [];
      const currentLang = window.ETBuilderBackendDynamic && window.ETBuilderBackendDynamic.lsadGlobalObj &&  window.ETBuilderBackendDynamic.lsadGlobalObj.lsadCurrentLang ? window.ETBuilderBackendDynamic.lsadGlobalObj.lsadCurrentLang : '';
      this.setState({ polylangData, currentLang });
      
    }, 1000);
  }

  static css(props) {
    return staticCSS(props);
  }

  render() {
    const { polylangData, currentLang } = this.state;
    const style = this.props.lsad_style ? this.props.lsad_style : 'horizontal';
    const flagDisplay = this.props.lsad_flag_visibility ? this.props.lsad_flag_visibility : 'on';
    const nameDisplay = this.props.lsad_language_name_visibility ? this.props.lsad_language_name_visibility : 'on';
    const codeDisplay = this.props.lsad_language_code_visibility ? this.props.lsad_language_code_visibility : 'off';
    const hideCurrentLang = this.props.lsad_current_lang_visibility ? this.props.lsad_current_lang_visibility : 'off';
    const hideUntranslateLang = this.props.lsad_unstranslated_lang_visibility ? this.props.lsad_unstranslated_lang_visibility : 'off';
    const pluginUrl=window.ETBuilderBackendDynamic && window.ETBuilderBackendDynamic.lsadGlobalObj && window.ETBuilderBackendDynamic.lsadGlobalObj.lsadPluginUrl ? window.ETBuilderBackendDynamic.lsadGlobalObj.lsadPluginUrl : '';
 
    return (
      polylangData && Object.keys(polylangData) && Object.keys(polylangData).length > 0? (
        <>
        <div className={`lsad-wrapper ${style}`}>
        {'dropdown' === style &&
          flagDisplay === 'on' && (
            polylangData && polylangData[currentLang] ? (
            <span>
              {flagDisplay === 'on' && <CountryFlag flagCode={polylangData[currentLang].flagCode} name={polylangData[currentLang].name} url={pluginUrl}/>}
              {nameDisplay === 'on' && <CountryName name={polylangData[currentLang].name} />}
              {codeDisplay === 'on' && <CountryCode code={polylangData[currentLang].slug} />}
            </span>
          ):<>No current available languages</>)}
        {this.props.lsad_visibility === 'on' && (
          <>
          <ul>
            {
              polylangData && Object.keys(polylangData) && Object.keys(polylangData).length > 0 ? (
                <>
                  {Object.keys(polylangData).map((lang, index) => {
                    if (lang === currentLang && 'on' === hideCurrentLang) {
                      return null;
                    }

                    if (polylangData[lang].no_translation && 'on' === hideUntranslateLang) {
                      return null;
                    }

                    if (lang === currentLang && 'dropdown' === style) {
                      return null;
                    }

                    return (
                      <li key={index} className={lang === currentLang ? 'lsad_active_lang' : ''}>
                        {flagDisplay === 'on' && <CountryFlag flagCode={polylangData[lang].flagCode} name={polylangData[lang].name} url={pluginUrl}/>}
                        {nameDisplay === 'on' && <CountryName name={polylangData[lang].name} />}
                        {codeDisplay === 'on' && <CountryCode code={polylangData[lang].slug} />}
                      </li>
                    );
                  })}
                </>
              ):(<>No available languages</>)
            }
          </ul>
          </>
        )}
      </div></>
      ):<>No available languages</>
  
    );
  }
}

export default LSAD_Module;
