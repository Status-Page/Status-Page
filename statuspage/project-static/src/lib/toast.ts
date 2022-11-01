// @ts-expect-error
import EventHandler from './dom/event-handler.js'
// @ts-expect-error
import Manipulator from './dom/manipulator.js'

const TRANSITION_END = 'transitionend';
const MILLISECONDS_MULTIPLIER = 1000;

const CLASS_NAME_FADE = 'fade';
const CLASS_NAME_SHOW = 'show';
const CLASS_NAME_HIDE = 'hide';
const CLASS_NAME_SHOWING = 'showing';
const SELECTOR_DATA_DISMISS = '[data-sp-dismiss="toast"]';

const DATA_KEY = 'toast';
const EVENT_KEY = `.${DATA_KEY}`;

const EVENT_CLICK_DISMISS = `click.dismiss${EVENT_KEY}`;
const EVENT_MOUSEOVER = `mouseover${EVENT_KEY}`;
const EVENT_MOUSEOUT = `mouseout${EVENT_KEY}`;
const EVENT_FOCUSIN = `focusin${EVENT_KEY}`;
const EVENT_FOCUSOUT = `focusout${EVENT_KEY}`;
const EVENT_HIDE = `hide${EVENT_KEY}`;
const EVENT_HIDDEN = `hidden${EVENT_KEY}`;
const EVENT_SHOW = `show${EVENT_KEY}`;
const EVENT_SHOWN = `shown${EVENT_KEY}`;

interface ConfigType {
    animation: boolean;
    autohide: boolean;
    delay: number;
}

const DefaultConfig: ConfigType = {
    animation: true,
    autohide: true,
    delay: 5000
};

export class Toast {
    private readonly _element: Element;
    private _timeout: NodeJS.Timeout | null;
    private _config: ConfigType;
    private _hasMouseInteraction: boolean;
    private _hasKeyboardInteraction: boolean;

    constructor(element: Element, config?: ConfigType) {
        this._element = element;
        this._timeout = null;
        this._hasMouseInteraction = false;
        this._hasKeyboardInteraction = false;
        this._config = this._getConfig(config);

        this._setListeners();
    }

    _getConfig(config?: ConfigType) {
        return {
            ...DefaultConfig,
            ...Manipulator.getDataAttributes(this._element),
            ...(typeof config === 'object' && config ? config : {})
        }
    }

    show() {
        const showEvent = EventHandler.trigger(this._element, EVENT_SHOW)

        if (showEvent.defaultPrevented) {
            return
        }

        this._clearTimeout()

        if (this._config.animation) {
            this._element.classList.add(CLASS_NAME_FADE)
        }

        const complete = () => {
            this._element.classList.remove(CLASS_NAME_SHOWING)
            this._element.classList.add(CLASS_NAME_SHOW)

            EventHandler.trigger(this._element, EVENT_SHOWN)

            this._maybeScheduleHide()
        }

        this._element.classList.remove(CLASS_NAME_HIDE)
        reflow(this._element)
        this._element.classList.add(CLASS_NAME_SHOWING)

        this._queueCallback(complete, this._element, this._config.animation)
    }

    hide() {
        if (!this._element.classList.contains(CLASS_NAME_SHOW)) {
            return
        }

        const hideEvent = EventHandler.trigger(this._element, EVENT_HIDE)

        if (hideEvent.defaultPrevented) {
            return
        }

        const complete = () => {
            this._element.classList.add(CLASS_NAME_HIDE)
            EventHandler.trigger(this._element, EVENT_HIDDEN)
        }

        this._element.classList.remove(CLASS_NAME_SHOW)
        this._queueCallback(complete, this._element, this._config.animation)
    }

    dispose() {
        this._clearTimeout()

        if (this._element.classList.contains(CLASS_NAME_SHOW)) {
            this._element.classList.remove(CLASS_NAME_SHOW)
        }
    }

    _maybeScheduleHide() {
        if (!this._config.autohide) {
            return
        }

        if (this._hasMouseInteraction || this._hasKeyboardInteraction) {
            return
        }

        this._timeout = setTimeout(() => {
            this.hide()
        }, this._config.delay)
    }

    _onInteraction(event: Event, isInteracting: boolean) {
        switch (event.type) {
            case 'mouseover':
            case 'mouseout':
                this._hasMouseInteraction = isInteracting
                break
            case 'focusin':
            case 'focusout':
                this._hasKeyboardInteraction = isInteracting
                break
            default:
                break
        }

        if (isInteracting) {
            this._clearTimeout()
            return
        }

        // @ts-expect-error
        const nextElement = event.relatedTarget
        if (this._element === nextElement || this._element.contains(nextElement)) {
            return
        }

        this._maybeScheduleHide()
    }

    _setListeners() {
        EventHandler.on(this._element, EVENT_CLICK_DISMISS, SELECTOR_DATA_DISMISS, () => this.hide())
        EventHandler.on(this._element, EVENT_MOUSEOVER, (event: Event) => this._onInteraction(event, true))
        EventHandler.on(this._element, EVENT_MOUSEOUT, (event: Event) => this._onInteraction(event, false))
        EventHandler.on(this._element, EVENT_FOCUSIN, (event: Event) => this._onInteraction(event, true))
        EventHandler.on(this._element, EVENT_FOCUSOUT, (event: Event) => this._onInteraction(event, false))
    }

    _clearTimeout() {
        // @ts-expect-error
        clearTimeout(this._timeout)
        this._timeout = null
    }

    _queueCallback(callback: Function, element: Element, isAnimated = true) {
        executeAfterTransition(callback, element, isAnimated)
    }
}

const execute = (callback: Function) => {
    if (typeof callback === 'function') {
        callback();
    }
}

const getTransitionDurationFromElement = (element: Element) => {
    if (!element) {
        return 0;
    }

    // Get transition-duration of the element
    let { transitionDuration, transitionDelay } = window.getComputedStyle(element);

    const floatTransitionDuration = Number.parseFloat(transitionDuration);
    const floatTransitionDelay = Number.parseFloat(transitionDelay);

    // Return 0 if element or transition duration is not found
    if (!floatTransitionDuration && !floatTransitionDelay) {
        return 0;
    }

    // If multiple durations are defined, take the first
    transitionDuration = transitionDuration.split(',')[0];
    transitionDelay = transitionDelay.split(',')[0];

    return (Number.parseFloat(transitionDuration) + Number.parseFloat(transitionDelay)) * MILLISECONDS_MULTIPLIER;
}

const triggerTransitionEnd = (element: Element) => {
    element.dispatchEvent(new Event(TRANSITION_END))
}

const executeAfterTransition = (callback: Function, transitionElement: Element, waitForTransition = true) => {
    if (!waitForTransition) {
        execute(callback);
        return;
    }

    const durationPadding = 5;
    const emulatedDuration = getTransitionDurationFromElement(transitionElement) + durationPadding;

    let called = false;

    const handler = ({ target }: { target: Element }) => {
        if (target !== transitionElement) {
            return;
        }

        called = true;
        // @ts-expect-error
        transitionElement.removeEventListener(TRANSITION_END, handler);
        execute(callback);
    }

    // @ts-expect-error
    transitionElement.addEventListener(TRANSITION_END, handler)
    setTimeout(() => {
        if (!called) {
            triggerTransitionEnd(transitionElement)
        }
    }, emulatedDuration)
}

// @ts-expect-error
const reflow = (element: Element) => element.offsetHeight;

type ToastLevel = 'danger' | 'warning' | 'success' | 'info';

export function createToast(
  level: ToastLevel,
  title: string,
  message: string,
  extra?: string,
): Toast {
  let iconName = 'mdi-alert';
  switch (level) {
    case 'warning':
      iconName = 'mdi-alert';
      break;
    case 'success':
      iconName = 'mdi-check-circle';
      break;
    case 'info':
      iconName = 'mdi-information';
      break;
    case 'danger':
      iconName = 'mdi-alert';
      break;
  }

  const container = document.createElement('div');
  container.setAttribute('class', 'toast-container position-fixed bottom-0 end-0 m-3');

  const main = document.createElement('div');
  main.setAttribute('class', `toast bg-${level}`);
  main.setAttribute('role', 'alert');
  main.setAttribute('aria-live', 'assertive');
  main.setAttribute('aria-atomic', 'true');

  const header = document.createElement('div');
  header.setAttribute('class', `toast-header bg-${level} text-body`);

  const icon = document.createElement('i');
  icon.setAttribute('class', `mdi ${iconName}`);

  const titleElement = document.createElement('strong');
  titleElement.setAttribute('class', 'me-auto ms-1');
  titleElement.innerText = title;

  const button = document.createElement('button');
  button.setAttribute('type', 'button');
  button.setAttribute('class', 'btn-close');
  button.setAttribute('data-bs-dismiss', 'toast');
  button.setAttribute('aria-label', 'Close');

  const body = document.createElement('div');
  body.setAttribute('class', 'toast-body');

  header.appendChild(icon);
  header.appendChild(titleElement);

  if (typeof extra !== 'undefined') {
    const extraElement = document.createElement('small');
    extraElement.setAttribute('class', 'text-gray-400');
    header.appendChild(extraElement);
  }

  header.appendChild(button);

  body.innerText = message.trim();

  main.appendChild(header);
  main.appendChild(body);
  container.appendChild(main);
  document.body.appendChild(container);

  return new Toast(main);
}
