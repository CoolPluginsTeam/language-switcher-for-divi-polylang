// External Dependencies
import React, { Component } from 'react';
import { CountryFlag, CountryName, CountryCode, staticCSS } from '../render_content';

// Internal Dependencies
import './style.css';

class CPFD_Module extends Component {

  static slug = 'connect-polylang-for-divi';

  constructor(props) {
    super(props);
    this.state = {
      languageData: null,
      currentLang: null
    };
  }

  componentDidMount() {
    setTimeout(() => {
      const polylangData =window.ETBuilderBackendDynamic &&  window.ETBuilderBackendDynamic.cpfdGlobalObj &&  window.ETBuilderBackendDynamic.cpfdGlobalObj.cpfdLanguageData ? window.ETBuilderBackendDynamic.cpfdGlobalObj.cpfdLanguageData : [];
      const currentLang = window.ETBuilderBackendDynamic && window.ETBuilderBackendDynamic.cpfdGlobalObj &&  window.ETBuilderBackendDynamic.cpfdGlobalObj.cpfdCurrentLang ? window.ETBuilderBackendDynamic.cpfdGlobalObj.cpfdCurrentLang : '';
      this.setState({ polylangData, currentLang });
      const thisModule = document.querySelector('.cpfd-wrapper.dropdown');
      const parentRow = thisModule.closest('.et_pb_row');
      console.log(parentRow);
      if (parentRow) {
        parentRow.style.setProperty('z-index', '999');
      }
    }, 1000);
  }


  static css(props) {
    return staticCSS(props);
  }


  render() {
    const { polylangData, currentLang } = this.state;
    const style = this.props.cpfd_style ? this.props.cpfd_style : 'dropdown';
    const flagDisplay = this.props.cpfd_flag_visibility ? this.props.cpfd_flag_visibility : 'on';
    const nameDisplay = this.props.cpfd_language_name_visibility ? this.props.cpfd_language_name_visibility : 'on';
    const codeDisplay = this.props.cpfd_language_code_visibility ? this.props.cpfd_language_code_visibility : 'off';
    const hideCurrentLang = this.props.cpfd_current_lang_visibility ? this.props.cpfd_current_lang_visibility : 'off';
    const hideUntranslateLang = this.props.cpfd_unstranslated_lang_visibility ? this.props.cpfd_unstranslated_lang_visibility : 'off';
    const pluginUrl=window.ETBuilderBackendDynamic && window.ETBuilderBackendDynamic.cpfdGlobalObj && window.ETBuilderBackendDynamic.cpfdGlobalObj.cpfdPluginUrl ? window.ETBuilderBackendDynamic.cpfdGlobalObj.cpfdPluginUrl : '';
 
    return (
      polylangData && Object.keys(polylangData) && Object.keys(polylangData).length > 0? (
        <>
        <div className={`cpfd-wrapper ${style}`}>
        {'dropdown' === style &&
          (
            polylangData && polylangData[currentLang] ? (
            <span>
              <a href={polylangData[currentLang].url}>
                {flagDisplay === 'on' && <CountryFlag flagCode={polylangData[currentLang].flagCode} name={polylangData[currentLang].name} url={pluginUrl}/>}
                {nameDisplay === 'on' && <CountryName name={polylangData[currentLang].name} />}
                {codeDisplay === 'on' && <CountryCode code={polylangData[currentLang].slug} />}
              </a>
            </span>
          ):<>No current available languages</>)}
        {(
          <>
          <ul className="cpfd-language-list" style={{zIndex: 999}}>
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
                      <li key={index} className={lang === currentLang ? 'cpfd_active_lang' : ''} style={{zIndex: 999}}>
                        <a href={polylangData[lang].url}>
                          {flagDisplay === 'on' && <CountryFlag flagCode={polylangData[lang].flagCode} name={polylangData[lang].name} url={pluginUrl}/>}
                          {nameDisplay === 'on' && <CountryName name={polylangData[lang].name} />}
                          {codeDisplay === 'on' && <CountryCode code={polylangData[lang].slug} />}
                        </a>
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

export default CPFD_Module;
