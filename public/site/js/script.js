(() => {
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  const ready = (fn) => {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', fn, { once: true });
      return;
    }
    fn();
  };

  const safeQuery = (selector, root = document) => root.querySelector(selector);
  const safeQueryAll = (selector, root = document) => Array.from(root.querySelectorAll(selector));

  const setupMobileNavigation = () => {
    const hamburger = safeQuery('#hamburger');
    const navLinks = safeQuery('.nav-links');

    if (!hamburger || !navLinks) {
      return;
    }

    hamburger.addEventListener('click', () => {
      hamburger.classList.toggle('active');
      navLinks.classList.toggle('active');
    });

    safeQueryAll('.nav-link').forEach((link) => {
      link.addEventListener('click', () => {
        hamburger.classList.remove('active');
        navLinks.classList.remove('active');
      });
    });
  };

  const setupSmoothScroll = () => {
    safeQueryAll('a[href^="#"]').forEach((anchor) => {
      anchor.addEventListener('click', (event) => {
        const href = anchor.getAttribute('href');
        if (!href || href === '#') {
          return;
        }

        const target = safeQuery(href);
        if (!target) {
          return;
        }

        event.preventDefault();
        target.scrollIntoView({ behavior: prefersReducedMotion ? 'auto' : 'smooth', block: 'start' });
      });
    });
  };

  const showMessage = (node, text, type) => {
    node.textContent = text;
    node.className = type;
  };

  const setupContactForm = () => {
    const contactForm = safeQuery('#contact-form');
    const formMessage = safeQuery('#form-message');

    if (!contactForm || !formMessage) {
      return;
    }

    contactForm.addEventListener('submit', (event) => {
      event.preventDefault();

      const name = safeQuery('input[type="text"]', contactForm)?.value || '';
      const email = safeQuery('input[type="email"]', contactForm)?.value || '';
      const message = safeQuery('textarea', contactForm)?.value || '';

      if (!name.trim() || !email.trim() || !message.trim()) {
        showMessage(formMessage, 'Please fill in all fields', 'error');
        return;
      }

      showMessage(formMessage, 'Message sent successfully! Thank you for reaching out.', 'success');
      contactForm.reset();

      window.setTimeout(() => {
        formMessage.textContent = '';
        formMessage.className = '';
      }, 5000);
    });
  };

  const setupRevealFallbacks = () => {
    const excludedParents = [
      '.w-nav',
      '.w-nav-menu',
      '.w-nav-button',
      '.w-dropdown',
      '.w-dropdown-list',
      '.w-tabs',
      '.w-tab-pane',
      '.w-form',
      '[class*="w-commerce"]',
      '.w-lightbox',
    ].join(', ');

    const targets = safeQueryAll(
      [
        '[data-w-id]',
        '.title-move-animation',
        '.cta-image-wrap',
        '.testimonial-element-wrap',
        '.footer-menu-list',
        '.footer-bottom-element',
        '.home-video-element',
        '.service-collection-list-wrapper',
        '.section-home-hero',
        '.button-wrap',
        '.w-dyn-item',
      ].join(', ')
    ).filter((element) => !element.closest(excludedParents));

    if (!targets.length) {
      return;
    }

    const observe = new IntersectionObserver(
      (entries, observer) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) {
            return;
          }

          const element = entry.target;
          element.style.opacity = '1';
          element.style.transform = 'none';
          element.style.transitionProperty = 'opacity, transform';
          element.style.transitionDuration = prefersReducedMotion ? '0ms' : '600ms';
          element.style.transitionTimingFunction = 'ease';
          observer.unobserve(element);
        });
      },
      {
        threshold: 0.15,
        rootMargin: '0px 0px -10% 0px',
      }
    );

    targets.forEach((element) => {
      const style = window.getComputedStyle(element);
      const inlineStyle = element.getAttribute('style') || '';
      const shouldMirror =
        style.opacity === '0' ||
        inlineStyle.includes('opacity: 0') ||
        inlineStyle.includes('translate3d') ||
        inlineStyle.includes('translateY') ||
        inlineStyle.includes('translateX');

      if (!shouldMirror) {
        return;
      }

      if (!prefersReducedMotion) {
        element.style.willChange = 'opacity, transform';
      }

      observe.observe(element);
    });
  };

  const setupCursor = () => {
    const cursorWrapper = safeQuery('.cursor-wrapper');
    const cursor = safeQuery('.cursor', cursorWrapper || document);
    const cursorText = safeQuery('.cursor-text-view', cursorWrapper || document);

    if (!cursorWrapper || !cursor) {
      return;
    }

    const interactiveSelector = 'a, button, [role="button"], input, textarea, select, .w-inline-block';
    const interactiveItems = safeQueryAll(interactiveSelector);
    let active = false;

    const setVisibility = (visible) => {
      cursor.style.opacity = visible ? '1' : '0';
      cursor.style.transform = visible
        ? 'translate3d(var(--cursor-x, 0px), var(--cursor-y, 0px), 0) translate(-50%, -50%)'
        : 'translate3d(var(--cursor-x, 0px), var(--cursor-y, 0px), 0) translate(-50%, -50%) scale(0.85)';
      if (cursorText) {
        cursorText.style.opacity = visible ? '1' : '0';
      }
    };

    const setPosition = (clientX, clientY) => {
      cursor.style.setProperty('--cursor-x', `${clientX}px`);
      cursor.style.setProperty('--cursor-y', `${clientY}px`);
    };

    document.addEventListener('pointermove', (event) => {
      if (event.pointerType === 'touch') {
        return;
      }

      setPosition(event.clientX, event.clientY);
      setVisibility(true);
      active = true;
    });

    document.documentElement.addEventListener('pointerleave', () => {
      if (!active) {
        return;
      }
      setVisibility(false);
      active = false;
    });

    interactiveItems.forEach((item) => {
      item.addEventListener('pointerenter', () => {
        setVisibility(true);
      });

      item.addEventListener('pointerleave', () => {
        if (!active) {
          setVisibility(false);
        }
      });
    });

    if (!prefersReducedMotion) {
      cursor.style.transition = 'opacity 180ms ease, transform 180ms ease';
      cursor.style.pointerEvents = 'none';
      cursor.style.position = 'fixed';
      cursor.style.left = '0';
      cursor.style.top = '0';
    }

    setVisibility(false);
  };

  ready(() => {
    setupMobileNavigation();
    setupSmoothScroll();
    setupContactForm();
    setupRevealFallbacks();
    setupCursor();
  });
})();
