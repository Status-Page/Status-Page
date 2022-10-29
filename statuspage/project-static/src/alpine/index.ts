import { initWindow } from './window';
import { initStart } from './start';

export function initAlpine(): void {
  for (const func of [initWindow, initStart]) {
    func();
  }
}

initAlpine();
