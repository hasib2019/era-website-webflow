/**
 * Opens the video lightbox on click.
 *
 * The export marks the trigger with Webflow's own `.w-lightbox` class and
 * ships `styles.css`'s full `.w-lightbox-*` rules, but the exported
 * `webflow.js` / `schunk.js` never actually contain the module that builds
 * the modal and binds the click -- Webflow's "export code" bundle drops it,
 * apparently relying on Webflow's own hosting to supply it. Nothing else in
 * the page can open the video, so this does the one thing that module would
 * have done: read the `<script class="w-json">` next to the trigger and
 * build the standard Webflow lightbox markup around its embed HTML.
 */
(function () {
    'use strict';

    var active = null;

    function closeLightbox() {
        if (! active) return;

        var backdrop = active.backdrop;
        var trigger = active.trigger;
        active = null;

        document.documentElement.classList.remove('w-lightbox-noscroll');
        document.removeEventListener('keydown', onKeydown);
        backdrop.remove();
        trigger.focus();
    }

    function onKeydown(e) {
        if (e.key === 'Escape') closeLightbox();
    }

    function embedFor(item) {
        if (item.type === 'video' && item.html) {
            return item.html;
        }

        if (item.type === 'image' && item.url) {
            var alt = (item.originalUrl || '').replace(/^.*\//, '');
            return '<img src="' + item.url + '" alt="' + alt + '" class="w-lightbox-img w-lightbox-image">';
        }

        return null;
    }

    function openLightbox(trigger, item) {
        var embed = embedFor(item);
        if (! embed) return;

        var backdrop = document.createElement('div');
        backdrop.className = 'w-lightbox-backdrop';
        backdrop.style.transition = 'opacity .3s';
        backdrop.setAttribute('role', 'dialog');
        backdrop.setAttribute('aria-modal', 'true');
        /*
         * `.w-lightbox-view` centers its content via flex here, set inline
         * rather than added to styles.css. styles.css's own `.w-lightbox-item`
         * is sized for the thumbnail strip (width: 10vh) and carries a
         * `transform`, which -- transform alone, regardless of position --
         * makes it a containing block; wrapping the embed in it, as an earlier
         * version of this file did, shrank the whole player to that 10vh box.
         * The embed sits directly in the view instead, so nothing here fights
         * that rule.
         */
        backdrop.innerHTML =
            '<div class="w-lightbox-container">' +
                '<div class="w-lightbox-content">' +
                    '<div class="w-lightbox-view" style="opacity: 1; display: flex; align-items: center; justify-content: center;">' +
                        embed +
                    '</div>' +
                    '<div class="w-lightbox-spinner"></div>' +
                    '<div class="w-lightbox-control w-lightbox-close" role="button" tabindex="0" aria-label="close lightbox"></div>' +
                '</div>' +
            '</div>';

        var media = backdrop.querySelector('.w-lightbox-view iframe, .w-lightbox-view img');
        if (media) {
            media.style.maxWidth = '90vw';
            media.style.maxHeight = '80vh';
            if (media.tagName === 'IFRAME') {
                var w = parseFloat(media.getAttribute('width')) || 16;
                var h = parseFloat(media.getAttribute('height')) || 9;
                media.style.aspectRatio = w + ' / ' + h;
                media.style.height = 'auto';
            }
        }

        document.body.appendChild(backdrop);
        document.documentElement.classList.add('w-lightbox-noscroll');

        var spinner = backdrop.querySelector('.w-lightbox-spinner');
        var iframe = backdrop.querySelector('iframe');
        if (iframe) {
            iframe.addEventListener('load', function () { spinner.classList.add('w-lightbox-hide'); });
        } else {
            spinner.classList.add('w-lightbox-hide');
        }

        // starts at opacity: 0 per styles.css; this is the fade-in
        requestAnimationFrame(function () { backdrop.style.opacity = '1'; });

        backdrop.addEventListener('click', function (e) {
            if (e.target === backdrop || e.target.closest('.w-lightbox-close')) {
                closeLightbox();
            }
        });

        document.addEventListener('keydown', onKeydown);
        backdrop.querySelector('.w-lightbox-close').focus();

        active = { backdrop: backdrop, trigger: trigger };
    }

    document.addEventListener('click', function (e) {
        var trigger = e.target.closest('.w-lightbox');
        if (! trigger) return;

        var json = trigger.querySelector('script.w-json');
        if (! json) return;

        e.preventDefault();

        var data;
        try {
            data = JSON.parse(json.textContent);
        } catch (err) {
            return;
        }

        var item = data.items && data.items[0];
        if (item) openLightbox(trigger, item);
    });
})();
