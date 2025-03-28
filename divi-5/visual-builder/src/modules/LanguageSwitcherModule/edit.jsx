import { ModuleStyles } from './module-styles';
import { ModuleScriptData } from './module-script-data';
import { moduleClassnames } from './module-classnames';

const { ModuleContainer } = window?.divi?.module;

export const LanguageSwitcherModuleEdit = ({
  attrs,
  elements,
  id,
  name,
}) => {
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
     <div>
      hi
     </div>
    </ModuleContainer>
  );
}