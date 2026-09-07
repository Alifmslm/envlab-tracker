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

// Toasts: slide in on load, auto-fade after data-toast-timeout ms with a
// shrinking progress bar. Manual close via [data-dismiss-alert] still works.
document.querySelectorAll('[data-toast]').forEach((toast) => {
    const timeout = parseInt(toast.getAttribute('data-toast-timeout') || '4500', 10);

    const bar = toast.querySelector('.toast-progress');
    if (bar) bar.style.animationDuration = `${timeout}ms`;

    // Entrance: hide first (before first paint), then reveal for a slide-up.
    toast.classList.add('transition-all', 'duration-300', 'opacity-0', 'translate-y-3');
    requestAnimationFrame(() => requestAnimationFrame(() => {
        toast.classList.remove('opacity-0', 'translate-y-3');
    }));

    const timer = setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-3');
        setTimeout(() => toast.remove(), 350);
    }, timeout);

    toast.querySelector('[data-dismiss-alert]')?.addEventListener('click', () => clearTimeout(timer));
});
