import { addAction } from '@wordpress/hooks';
import metadata from './LanguageSwitcherModule/module.json';
const LanguageSwitcherModuleMetadata = metadata;
import { LanguageSwitcherModule } from "./LanguageSwitcherModule";

const { registerModule } = window?.divi?.moduleLibrary;
addAction('divi.moduleLibrary.registerModuleLibraryStore.after', 'cpfd', () => {
  registerModule(LanguageSwitcherModuleMetadata, LanguageSwitcherModule);
});