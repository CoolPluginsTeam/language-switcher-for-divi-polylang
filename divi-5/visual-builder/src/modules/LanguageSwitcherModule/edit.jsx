import { useEffect, useState } from 'react';
import { ModuleStyles } from './module-styles';
import { ModuleScriptData } from './module-script-data';
import { moduleClassnames } from './module-classnames';
import { getAttrDataValues } from './moduleHelper';
//use the render_content file from the includes folder divi-4
import { CountryFlag, CountryName, CountryCode } from "../../../../../includes/modules/render_content";

// Divi hooks
const { useFetch } = window?.divi?.rest;
const { ModuleContainer } = window?.divi?.module;

export const LanguageSwitcherModuleEdit = (props) => {
  const [polylangData, setPolylangData] = useState(null);
  const [currentLang, setCurrentLang] = useState(null);
  const [pluginUrl, setPluginUrl] = useState(null);
  const {
    attrs,
    elements,
    id,
    name,
  } = props;
  const {
    fetch,
    response,
    isLoading,
  } = useFetch({ language_switcher_data: '' });

  useEffect(() => {
    if (response?.language_switcher_data?.cpfdGlobalObj) {
      setPolylangData(response?.language_switcher_data?.cpfdGlobalObj?.cpfdLanguageData);
      setCurrentLang(response?.language_switcher_data?.cpfdGlobalObj?.cpfdCurrentLang);
      setPluginUrl(response?.language_switcher_data?.cpfdGlobalObj?.cpfdPluginUrl);
    }
  }, [response]);

  const attributes = getAttrDataValues(attrs);
  const language_switcher_module_data = () => {
    fetch({
      method: 'GET',
      restRoute: '/cpfd/v1/module-data/language-switcher-module',
    })
    .catch((error) => {
      console.error('Error fetching data:', error);
    });
  }

  useEffect(() => {
    language_switcher_module_data();
    setTimeout(() => {
    const thisModule = document.querySelector('.cpfd_connect_polylang_for_divi');

    const parentRow = thisModule.parentNode;
    if (parentRow) {
      if(parentRow.style.getPropertyValue('z-index') !== '999'){
        parentRow.style.setProperty('z-index', '999');
      }
    }
    }, 1000);
  }, [attributes?.switcher_layouts]);

  return (
    <>
    <ModuleContainer
      attrs={attrs}
      elements={elements} 
      moduleClassName = 'cpfd_connect_polylang_for_divi'
      id={id}
      name={name}
      scriptDataComponent={ModuleScriptData}
      stylesComponent={ModuleStyles}
      classnamesFunction={moduleClassnames}
    >
      {isLoading ? (
        <div id="et-fb-app" className="et-fb-page-preloading"></div>
        ) : (
         (
          polylangData && (Object.keys(polylangData).length > 0)  ? (
            <div className='cpfd-main-wrapper'>
              <div className={`cpfd-wrapper ${attributes.switcher_layouts}`}>
              {attributes?.switcher_layouts === 'dropdown' && (
                polylangData?.[currentLang] ? (
                  <span>
                    <a href={polylangData?.[currentLang]?.url}>
                      {attributes?.show_language_flag === 'on' && <CountryFlag flagCode={polylangData?.[currentLang]?.flagCode} name={polylangData?.[currentLang]?.name} url={pluginUrl} />}
                      {attributes?.show_language_name === 'on' && <CountryName name={polylangData?.[currentLang]?.name} />}
                      {attributes?.show_language_code === 'on' && <CountryCode code={polylangData?.[currentLang]?.slug} />}
                    </a>
                  </span>
                ) : (
                  <>No current available languages</>
                )
              )}
              { (
                <ul style={{zIndex: 999}}>
                {
                polylangData && Object.keys(polylangData) && Object.keys(polylangData).length > 0 ? (
                  <>
                    {Object.keys(polylangData).map((lang, index) => {
                      if (lang === currentLang && 'on' === attributes?.hide_current_language) {
                        return null;
                      }

                      // if (polylangData[lang].no_translation && 'on' === attributes?.hide_untranslated_language) {
                      //   return null;
                      // }

                      if (lang === currentLang && 'dropdown' === attributes?.switcher_layouts) {
                        return null;
                      }

                      return (
                        <li key={index} className={lang === currentLang ? 'cpfd_active_lang' : ''}>
                          <a href={polylangData?.[lang]?.url}>
                            {attributes?.show_language_flag === 'on' && <CountryFlag flagCode={polylangData?.[lang]?.flagCode} name={polylangData?.[lang]?.name} url={pluginUrl}/>}
                            {attributes?.show_language_name === 'on' && <CountryName name={polylangData?.[lang]?.name} />}
                            {attributes?.show_language_code === 'on' && <CountryCode code={polylangData?.[lang]?.slug} />}
                          </a>
                        </li>
                      );
                    })}
                  </>
                ):(<>No available languages</>)
              }
              </ul>            
              )}
            </div>
          </div>
        ) : (
          <>No available languages</>
        ))
      )}
    </ModuleContainer>
    </>
  );
}