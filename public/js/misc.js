/******/ (() => { // webpackBootstrap
/*!******************************!*\
  !*** ./resources/js/misc.js ***!
  \******************************/
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */
tippy('button', {
  content: function content(reference) {
    return reference.getAttribute('data-title');
  },
  onMount: function onMount(instance) {
    instance.popperInstance.setOptions({
      placement: instance.reference.getAttribute('data-placement')
    });
  }
});
/******/ })()
;