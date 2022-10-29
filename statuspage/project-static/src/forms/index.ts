import { initFormElements } from './elements';
import { initSpeedSelector } from './speedSelector';
import { initScopeSelector } from './scopeSelector';
import { initFiltersets } from './filtersets';

export function initForms(): void {
  for (const func of [initFormElements, initSpeedSelector, initScopeSelector, initFiltersets]) {
    func();
  }
}
