import { LanguageSwitcherModuleEdit } from './edit';
import { conversionOutline } from './conversion-outline';
import { SettingsAdvanced } from './settings-advanced';
import { SettingsContent } from './settings-content';
import { SettingsDesign } from './settings-design';

export const LanguageSwitcherModule = {
  renderers: {
    edit: LanguageSwitcherModuleEdit,
  },
  settings: {
    content: SettingsContent,
    design: SettingsDesign,
    advanced: SettingsAdvanced,
  },
  conversionOutline,
};