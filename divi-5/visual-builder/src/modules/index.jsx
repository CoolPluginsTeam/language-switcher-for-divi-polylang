import { addAction } from '@wordpress/hooks';

import { LanguageSwitcherModule, LanguageSwitcherModuleMetadata } from "./LanguageSwitcherModule";

const { registerModule } = window?.divi?.moduleLibrary;

addAction('divi.moduleLibrary.registerModuleLibraryStore.after', 'cpfd', () => {
  registerModule(LanguageSwitcherModuleMetadata, LanguageSwitcherModule);
});