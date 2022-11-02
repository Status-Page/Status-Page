import { initForms } from './forms';
import { initSearch } from './search';
import { initSelect } from './select';
import { initButtons } from './buttons';
import { initColorMode } from './colorMode';
import { initMessages } from './messages';
import { initClipboard } from './clipboard';
import { initDateSelector } from './dateSelector';
import { initTableConfig } from './tableConfig';
import { initInterfaceTable } from './tables';
import { initLinks } from './links';
import { initHtmx } from './htmx';
import { initPopups } from "./popups";

function initDocument(): void {
  for (const init of [
    initColorMode,
    initMessages,
    initForms,
    initSearch,
    initSelect,
    initDateSelector,
    initButtons,
    initClipboard,
    initTableConfig,
    initInterfaceTable,
    initLinks,
    initHtmx,
    initPopups,
  ]) {
    init();
  }
}

function initWindow(): void {
  const documentForms = document.forms;
  for (const documentForm of documentForms) {
    if (documentForm.method.toUpperCase() == 'GET') {
      documentForm.addEventListener('formdata', function (event: FormDataEvent) {
        const formData: FormData = event.formData;
        for (const [name, value] of Array.from(formData.entries())) {
          if (value === '') formData.delete(name);
        }
      });
    }
  }

  const contentContainer = document.querySelector<HTMLElement>('.content-container');
  if (contentContainer !== null) {
    // Focus the content container for accessible navigation.
    contentContainer.focus();
  }
}

window.addEventListener('load', initWindow);

if (document.readyState !== 'loading') {
  initDocument();
} else {
  document.addEventListener('DOMContentLoaded', initDocument);
}
