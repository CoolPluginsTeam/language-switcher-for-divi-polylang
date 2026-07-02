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
    if (response?.language_switcher_data?.lsdpGlobalObj) {
      setPolylangData(response?.language_switcher_data?.lsdpGlobalObj?.lsdpLanguageData);
      setCurrentLang(response?.language_switcher_data?.lsdpGlobalObj?.lsdpCurrentLang);
      setPluginUrl(response?.language_switcher_data?.lsdpGlobalObj?.lsdpPluginUrl);
    }
  }, [response]);

  const attributes = getAttrDataValues(attrs);
  const language_switcher_module_data = () => {
    fetch({
      method: 'GET',
      restRoute: '/lsdp/v1/module-data/language-switcher-module',
    })
    .catch((error) => {
      console.error('Error fetching data:', error);
    });
  }

  useEffect(() => {
    language_switcher_module_data();
    setTimeout(() => {
    const thisModule = document.querySelector('.lsdp_language_switcher_for_divi_polylang');
    if (!thisModule) {
      return;
    }
    const parentRow = thisModule.parentNode;
    if (parentRow) {
      if(parentRow.style.getPropertyValue('z-index') !== '999'){
        parentRow.style.setProperty('z-index', '999');
      }
    }
    if (thisModule) {
      thisModule.style.setProperty('z-index', '999'); 
    }
    }, 1000);
  }, [attributes?.switcher_layouts]);

  return (
    <>
    <ModuleContainer
      attrs={attrs}
      elements={elements} 
      moduleClassName = 'lsdp_language_switcher_for_divi_polylang'
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
            <div className='lsdp-main-wrapper'>
              <div className={`lsdp-wrapper ${attributes.switcher_layouts}`}>
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

                      if (lang === currentLang && 'dropdown' === attributes?.switcher_layouts) {
                        return null;
                      }

                      return (
                        <li key={index} className={lang === currentLang ? 'lsdp_active_lang' : ''}>
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