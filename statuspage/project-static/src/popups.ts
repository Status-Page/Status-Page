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

    const globalTooltip = document.createElement('div');
    globalTooltip.classList.add('hidden', 'bg-zinc-400', 'dark:bg-zinc-900', 'text-black', 'dark:text-white', 'px-2', 'py-1', 'rounded-md');
    document.body.appendChild(globalTooltip);

    for (const component of getElements<SVGRectElement>('rect[data-tooltip]')) {
        const timestamp = component.getAttribute('data-tooltip') ?? 'Unknown';

        const showEvents = ['mouseenter', 'focus'];
        const hideEvents = ['mouseleave', 'blur'];

        showEvents.forEach((event) => {
          component.addEventListener(event, () => {
            window.globalPopper = createPopper(component, globalTooltip, {
                placement: 'top',
            });
            globalTooltip.innerHTML = `${timestamp}`;
            globalTooltip.classList.remove('hidden');
            window.globalPopper.update();
          });
        });

        hideEvents.forEach((event) => {
          component.addEventListener(event, () => {
            globalTooltip.classList.add('hidden');
            window.globalPopper.destroy();
          });
        });
    }
}
