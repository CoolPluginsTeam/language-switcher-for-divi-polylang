import { addAction } from '@wordpress/hooks';
import LanguageSwitcherModuleMetadata  from './LanguageSwitcherModule/module.json';
import { LanguageSwitcherModule } from "./LanguageSwitcherModule";
const { registerModule } = window?.divi?.moduleLibrary;
addAction('divi.moduleLibrary.registerModuleLibraryStore.after', 'cpfd', () => {
  registerModule(LanguageSwitcherModuleMetadata, LanguageSwitcherModule);
});