import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Pure vanilla JS UI controller. No dependencies.
//
// Conventions:
// - `[data-open-modal="some-id"]`  opens the modal with that id.
// - `[data-close-modal]`            closes the nearest enclosing `.fixed` modal.
// - Clicking the backdrop or pressing Escape closes the topmost open modal.
// - `[data-dismiss-alert]`          removes the enclosing `[role="alert"]`.
// - `window.EnvLabModal.open(id)`   programmatic open (e.g. after validation
//   failure). Safe to call from inline scripts on DOMContentLoaded.

function openModalById(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.classList.remove('hidden');
    el.classList.add('flex');
    document.body.classList.add('overflow-hidden');
}

function closeModalEl(el) {
    if (!el) return;
    el.classList.add('hidden');
    el.classList.remove('flex');
    if (!document.querySelector('.fixed[id^="modal-"]:not(.hidden)')) {
        document.body.classList.remove('overflow-hidden');
    }
}

window.EnvLabModal = { open: openModalById, close: closeModalEl };

document.addEventListener('click', (event) => {
    const opener = event.target.closest('[data-open-modal]');
    if (opener) {
        openModalById(opener.getAttribute('data-open-modal'));
        return;
    }

    const closer = event.target.closest('[data-close-modal]');
    if (closer) {
        const modal = closer.closest('.fixed[id^="modal-"]');
        closeModalEl(modal);
        return;
    }

    const dismisser = event.target.closest('[data-dismiss-alert]');
    if (dismisser) {
        const alert = dismisser.closest('[role="alert"]');
        if (alert) alert.remove();
    }
});

document.querySelectorAll('.fixed[id^="modal-"]').forEach((modal) => {
    modal.addEventListener('click', (event) => {
        if (event.target === modal) closeModalEl(modal);
    });
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        document
            .querySelectorAll('.fixed[id^="modal-"]:not(.hidden)')
            .forEach(closeModalEl);
    }
});
