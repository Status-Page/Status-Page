import { getElements} from "./util";
import { createPopper } from "@popperjs/core";

export function initPopups(){
    for (const component of getElements<HTMLDivElement>('div[data-tooltip]')) {
        const timestamp = component.getAttribute('data-tooltip') ?? 'Unknown';

        const tooltip = document.createElement('div');
        tooltip.classList.add('hidden', 'bg-zinc-400', 'dark:bg-zinc-900', 'px-2', 'py-1', 'rounded-md');
        tooltip.innerHTML = `${timestamp}`;

        component.before(tooltip);

        const instance = createPopper(component, tooltip, {
            placement: 'top',
        });

        const showEvents = ['mouseenter', 'focus'];
        const hideEvents = ['mouseleave', 'blur'];

        showEvents.forEach((event) => {
          component.addEventListener(event, () => {
            tooltip.classList.remove('hidden');
            instance.update();
          });
        });

        hideEvents.forEach((event) => {
          component.addEventListener(event, () => {
            tooltip.classList.add('hidden');
          });
        });
    }
}
