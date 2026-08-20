/**
 * Dashboard behaviour. Deliberately dependency-free: the public site already
 * ships jQuery and the Webflow runtime, and the two must not meet.
 */

document.addEventListener('DOMContentLoaded', () => {
    // sidebar toggle on narrow screens
    const sidebar = document.querySelector('[data-sidebar]');
    document.querySelectorAll('[data-sidebar-toggle]').forEach((btn) => {
        btn.addEventListener('click', () => sidebar?.classList.toggle('hidden'));
    });

    // dismissible flash messages
    document.querySelectorAll('[data-dismiss]').forEach((btn) => {
        btn.addEventListener('click', () => btn.closest('[data-flash]')?.remove());
    });

    // confirm before destructive form posts
    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (e) => {
            if (!window.confirm(form.dataset.confirm)) {
                e.preventDefault();
            }
        });
    });

    // repeatable rows in the section editors
    document.querySelectorAll('[data-repeater]').forEach((repeater) => {
        const list = repeater.querySelector('[data-repeater-list]');
        const template = repeater.querySelector('template');

        repeater.querySelector('[data-repeater-add]')?.addEventListener('click', () => {
            const index = list.children.length;
            list.insertAdjacentHTML('beforeend', template.innerHTML.replaceAll('__INDEX__', index));
        });

        list?.addEventListener('click', (e) => {
            if (e.target.closest('[data-repeater-remove]')) {
                e.target.closest('[data-repeater-row]')?.remove();
            }
        });
    });
});
