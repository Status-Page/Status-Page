/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

tippy('button', {
    content:(reference)=>reference.getAttribute('data-title'),
    onMount(instance) {
        instance.popperInstance.setOptions({
            placement :instance.reference.getAttribute('data-placement')
        });
    }
});
