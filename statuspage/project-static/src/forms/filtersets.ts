import { getElements } from "../util";

export function initFiltersets(){
  for (const resetButton of getElements<HTMLButtonElement>('button[data-reset-select]')) {
      resetButton.addEventListener('click', () => {
        window.location.assign(window.location.origin + window.location.pathname);
      });
  }
}
