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
    if (response?.language_switcher_data?.lsadGlobalObj) {
      setPolylangData(response?.language_switcher_data?.lsadGlobalObj?.lsadLanguangeData);
      setCurrentLang(response?.language_switcher_data?.lsadGlobalObj?.lsadCurrentLang);
      setPluginUrl(response?.language_switcher_data?.lsadGlobalObj?.lsadPluginUrl);
    }
  }, [response]);

  const attributes = getAttrDataValues(attrs);
  const language_switcher_module_data = () => {
    fetch({
      method: 'GET',
      restRoute: '/lsad/v1/module-data/language-switcher-module',
      data: {
        switcher_layouts: attributes?.switcher_layouts,
        show_language_flag: attributes?.show_language_flag,
        show_language_name: attributes?.show_language_name,
        show_language_code: attributes?.show_language_code,
        hide_current_language: attributes?.hide_current_language,
        hide_untranslated_language: attributes?.hide_untranslated_language,
      },
    })
    .catch((error) => {
      console.error('Error fetching data:', error);
    });
  }

  useEffect(() => {
    language_switcher_module_data();
  }, [attributes?.switcher_layouts, attributes?.show_language_flag, attributes?.show_language_name, attributes?.show_language_code, attributes?.hide_current_language, attributes?.hide_untranslated_language]);

  return (
    <ModuleContainer
      attrs={attrs}
      elements={elements} 
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
            
            <div className={`lsad-wrapper ${attributes.switcher_layouts}`}>
            {attributes?.switcher_layouts === 'dropdown' && (
              polylangData?.[currentLang] ? (
                <span>
                  {attributes?.show_language_flag === 'on' && <CountryFlag flagCode={polylangData?.[currentLang]?.flagCode} name={polylangData?.[currentLang]?.name} url={pluginUrl} />}
                  {attributes?.show_language_name === 'on' && <CountryName name={polylangData?.[currentLang]?.name} />}
                  {attributes?.show_language_code === 'on' && <CountryCode code={polylangData?.[currentLang]?.slug} />}
                </span>
              ) : (
                <>No current available languages</>
              )
            )}
            { (
              <ul>
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
                      <li key={index} className={lang === currentLang ? 'lsad_active_lang' : ''}>
                        {attributes?.show_language_flag === 'on' && <CountryFlag flagCode={polylangData?.[lang]?.flagCode} name={polylangData?.[lang]?.name} url={pluginUrl}/>}
                        {attributes?.show_language_name === 'on' && <CountryName name={polylangData?.[lang]?.name} />}
                        {attributes?.show_language_code === 'on' && <CountryCode code={polylangData?.[lang]?.slug} />}
                      </li>
                    );
                  })}
                </>
              ):(<>No available languages</>)
            }
            </ul>            
            )}
          </div>
        ) : (
          <>No available languages</>
        ))
      )}
    </ModuleContainer>
  );
}