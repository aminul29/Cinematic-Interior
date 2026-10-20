/**
 * Nior Atelier Project Portfolio Gallery & Lightbox Controller
 * Handles card thumbnail hover previews, fullscreen lightbox navigation,
 * keyboard/swipe controls, and adjacent frame preloading.
 */

export function initProjectGallery() {
  const cards = document.querySelectorAll('.nior-portfolio-card[data-project-gallery]');
  const lightbox = document.getElementById('nior-project-lightbox');

  if (!cards.length || !lightbox) return;

  const els = {
    category: lightbox.querySelector('.nior-lightbox__category'),
    title: lightbox.querySelector('.nior-lightbox__title'),
    counter: lightbox.querySelector('.nior-lightbox__counter'),
    img: lightbox.querySelector('.nior-lightbox__img'),
    caption: lightbox.querySelector('.nior-lightbox__caption'),
    prevBtn: lightbox.querySelector('[data-lightbox-prev]'),
    nextBtn: lightbox.querySelector('[data-lightbox-next]'),
    closeBtns: lightbox.querySelectorAll('[data-lightbox-close]'),
    filmstrip: lightbox.querySelector('.nior-lightbox__filmstrip'),
    stage: lightbox.querySelector('.nior-lightbox__stage'),
  };

  let state = {
    isOpen: false,
    gallery: [],
    title: '',
    category: '',
    desc: '',
    currentIndex: 0,
    triggerCard: null,
  };

  const padNum = (n) => String(n).padStart(2, '0');

  const preloadAdjacent = (idx) => {
    const total = state.gallery.length;
    if (total <= 1) return;
    const nextIdx = (idx + 1) % total;
    const prevIdx = (idx - 1 + total) % total;
    [state.gallery[nextIdx], state.gallery[prevIdx]].forEach((url) => {
      if (url) {
        const img = new Image();
        img.src = url;
      }
    });
  };

  const updateStage = (index) => {
    const total = state.gallery.length;
    if (!total) return;

    const normalizedIndex = ((index % total) + total) % total;
    state.currentIndex = normalizedIndex;

    const targetUrl = state.gallery[normalizedIndex];
    els.counter.textContent = `${padNum(normalizedIndex + 1)} / ${padNum(total)}`;

    els.img.classList.add('is-switching');
    const loader = new Image();
    loader.onload = () => {
      els.img.src = targetUrl;
      els.img.alt = `${state.title} — Photo ${normalizedIndex + 1} of ${total}`;
      els.img.classList.remove('is-switching');

      if (loader.naturalWidth && loader.naturalHeight) {
        const aspect = loader.naturalWidth / loader.naturalHeight;
        lightbox.classList.toggle('is-compact-aspect', aspect < 1.15);
      }
    };
    loader.src = targetUrl;

    const thumbBtns = els.filmstrip.querySelectorAll('.nior-lightbox__thumb-btn');
    thumbBtns.forEach((btn, i) => {
      const isCurrent = i === normalizedIndex;
      btn.classList.toggle('is-active', isCurrent);
      btn.setAttribute('aria-selected', isCurrent ? 'true' : 'false');
      if (isCurrent) {
        btn.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
      }
    });

    preloadAdjacent(normalizedIndex);
  };

  const buildFilmstrip = () => {
    els.filmstrip.innerHTML = '';
    state.gallery.forEach((url, idx) => {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = `nior-lightbox__thumb-btn${idx === state.currentIndex ? ' is-active' : ''}`;
      btn.setAttribute('role', 'tab');
      btn.setAttribute('aria-label', `Photo ${idx + 1}`);
      btn.setAttribute('aria-selected', idx === state.currentIndex ? 'true' : 'false');

      const thumbImg = document.createElement('img');
      thumbImg.src = url;
      thumbImg.alt = '';
      thumbImg.loading = 'lazy';
      btn.appendChild(thumbImg);

      btn.addEventListener('click', () => updateStage(idx));
      els.filmstrip.appendChild(btn);
    });
  };

  const openLightbox = (card, startIndex = 0) => {
    let parsedGallery = [];
    try {
      parsedGallery = JSON.parse(card.dataset.projectGallery || '[]');
    } catch (e) {
      parsedGallery = [];
    }

    if (!parsedGallery.length) return;

    state = {
      isOpen: true,
      gallery: parsedGallery,
      title: card.dataset.projectTitle || '',
      category: card.dataset.projectCategory || '',
      desc: card.dataset.projectDesc || '',
      currentIndex: startIndex,
      triggerCard: card,
    };

    els.category.textContent = state.category;
    els.title.textContent = state.title;
    els.caption.textContent = state.desc;

    const showNav = parsedGallery.length > 1;
    els.prevBtn.style.display = showNav ? '' : 'none';
    els.nextBtn.style.display = showNav ? '' : 'none';

    buildFilmstrip();
    updateStage(startIndex);

    lightbox.classList.add('is-open');
    lightbox.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    if (window.niorLenis && typeof window.niorLenis.stop === 'function') {
      window.niorLenis.stop();
    }
  };

  const closeLightbox = () => {
    if (!state.isOpen) return;
    state.isOpen = false;
    lightbox.classList.remove('is-open');
    lightbox.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    if (window.niorLenis && typeof window.niorLenis.start === 'function') {
      window.niorLenis.start();
    }
    if (state.triggerCard) {
      state.triggerCard.focus({ preventScroll: true });
    }
  };

  // Wire up each project card & its mini thumbnail preview strip
  cards.forEach((card) => {
    const coverImg = card.querySelector('.nior-portfolio-card__cover-img');
    const thumbBtns = card.querySelectorAll('.nior-portfolio-card__thumb');

    thumbBtns.forEach((btn) => {
      const previewSrc = btn.dataset.photoSrc;
      const photoIdx = parseInt(btn.dataset.photoIndex || '0', 10);

      if (previewSrc && coverImg) {
        btn.addEventListener('mouseenter', () => {
          coverImg.src = previewSrc;
          thumbBtns.forEach((b) => b.classList.remove('is-active'));
          btn.classList.add('is-active');
        });
      }

      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        openLightbox(card, photoIdx);
      });
    });

    card.addEventListener('click', () => {
      const activeThumb = card.querySelector('.nior-portfolio-card__thumb.is-active');
      const startIdx = activeThumb ? parseInt(activeThumb.dataset.photoIndex || '0', 10) : 0;
      openLightbox(card, startIdx);
    });

    card.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        if (e.target === card) {
          e.preventDefault();
          openLightbox(card, 0);
        }
      }
    });
  });

  // Lightbox controls
  els.prevBtn?.addEventListener('click', () => updateStage(state.currentIndex - 1));
  els.nextBtn?.addEventListener('click', () => updateStage(state.currentIndex + 1));
  els.closeBtns.forEach((btn) => btn.addEventListener('click', closeLightbox));

  // Keyboard navigation
  document.addEventListener('keydown', (e) => {
    if (!state.isOpen) return;
    if (e.key === 'Escape') {
      e.preventDefault();
      closeLightbox();
    } else if (e.key === 'ArrowRight') {
      e.preventDefault();
      updateStage(state.currentIndex + 1);
    } else if (e.key === 'ArrowLeft') {
      e.preventDefault();
      updateStage(state.currentIndex - 1);
    }
  });

  // Touch swipe navigation on stage
  let touchStartX = 0;
  els.stage?.addEventListener(
    'touchstart',
    (e) => {
      if (e.touches.length === 1) {
        touchStartX = e.touches[0].clientX;
      }
    },
    { passive: true }
  );

  els.stage?.addEventListener(
    'touchend',
    (e) => {
      if (!touchStartX || !e.changedTouches.length) return;
      const deltaX = e.changedTouches[0].clientX - touchStartX;
      if (Math.abs(deltaX) > 45) {
        if (deltaX < 0) {
          updateStage(state.currentIndex + 1);
        } else {
          updateStage(state.currentIndex - 1);
        }
      }
      touchStartX = 0;
    },
    { passive: true }
  );

  // Backward-compatible smooth scroll for any remaining category anchor pills
  const anchorPills = document.querySelectorAll('.nior-category-nav__pill');
  anchorPills.forEach((pill) => {
    pill.addEventListener('click', (e) => {
      const href = pill.getAttribute('href');
      if (href && href.startsWith('#')) {
        const target = document.querySelector(href);
        if (target && window.niorLenis) {
          e.preventDefault();
          window.niorLenis.scrollTo(target, { offset: -80 });
        }
      }
    });
  });

  // Initialize interactive project category filtering
  initProjectFilter();
}

/**
 * Interactive Project Category Filter Controller
 * Handles animated category switching, counter updates, and URL hash sync.
 */
function initProjectFilter() {
  const filterBar = document.querySelector('.nior-portfolio-filter-bar');
  const cards = Array.from(document.querySelectorAll('.nior-portfolio-card[data-sector]'));
  if (!filterBar || !cards.length) return;

  const filterBtns = Array.from(filterBar.querySelectorAll('.nior-filter-btn'));
  const counterCurrent = filterBar.querySelector('.nior-filter-count-current');

  let activeFilter = 'all';
  let isAnimating = false;

  const getValidFilterFromHash = () => {
    const rawHash = (window.location.hash || '').replace(/^#/, '').trim();
    if (!rawHash) return 'all';
    const match = filterBtns.find((btn) => btn.dataset.filter === rawHash);
    return match ? rawHash : 'all';
  };

  const setFilterUI = (targetFilter) => {
    filterBtns.forEach((btn) => {
      const isSelected = btn.dataset.filter === targetFilter;
      btn.classList.toggle('is-active', isSelected);
      btn.setAttribute('aria-selected', isSelected ? 'true' : 'false');
      btn.setAttribute('tabindex', isSelected ? '0' : '-1');
    });
  };

  const applyFilter = (targetFilter, animate = true) => {
    activeFilter = targetFilter;
    setFilterUI(targetFilter);

    const matchingCards = [];
    const unmatchingCards = [];

    cards.forEach((card) => {
      const cardSector = card.dataset.sector;
      if (targetFilter === 'all' || cardSector === targetFilter) {
        matchingCards.push(card);
      } else {
        unmatchingCards.push(card);
      }
    });

    if (counterCurrent) {
      counterCurrent.textContent = matchingCards.length;
    }

    const { gsap, ScrollTrigger } = window;
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!animate || !gsap || prefersReducedMotion) {
      unmatchingCards.forEach((c) => {
        c.style.display = 'none';
        c.setAttribute('aria-hidden', 'true');
        c.setAttribute('tabindex', '-1');
      });
      matchingCards.forEach((c) => {
        c.style.display = '';
        c.setAttribute('aria-hidden', 'false');
        c.setAttribute('tabindex', '0');
        c.style.opacity = '1';
        c.style.transform = '';
      });
      if (ScrollTrigger) ScrollTrigger.refresh();
      return;
    }

    // GSAP Animated transition
    isAnimating = true;
    gsap.killTweensOf(cards);

    const revealMatchingCards = () => {
      matchingCards.forEach((c) => {
        c.style.display = '';
        c.setAttribute('aria-hidden', 'false');
        c.setAttribute('tabindex', '0');
      });

      gsap.fromTo(
        matchingCards,
        { opacity: 0, scale: 0.96, y: 16 },
        {
          opacity: 1,
          scale: 1,
          y: 0,
          duration: 0.38,
          stagger: {
            each: 0.04,
            from: 'start',
          },
          ease: 'power2.out',
          onComplete: () => {
            isAnimating = false;
            matchingCards.forEach((c) => {
              c.style.transform = '';
            });
            if (ScrollTrigger) ScrollTrigger.refresh();
          },
        }
      );
    };

    if (unmatchingCards.length) {
      gsap.to(unmatchingCards, {
        opacity: 0,
        scale: 0.94,
        y: 8,
        duration: 0.22,
        ease: 'power2.in',
        onComplete: () => {
          unmatchingCards.forEach((c) => {
            c.style.display = 'none';
            c.setAttribute('aria-hidden', 'true');
            c.setAttribute('tabindex', '-1');
          });
          revealMatchingCards();
        },
      });
    } else {
      revealMatchingCards();
    }
  };

  // Click & keyboard handlers for filter buttons
  filterBtns.forEach((btn, index) => {
    btn.addEventListener('click', () => {
      const targetFilter = btn.dataset.filter || 'all';
      if (targetFilter === activeFilter && !isAnimating) return;

      if (targetFilter === 'all') {
        if (window.location.hash) {
          history.pushState(null, '', window.location.pathname + window.location.search);
        }
      } else {
        if (window.location.hash !== `#${targetFilter}`) {
          history.pushState(null, '', `#${targetFilter}`);
        }
      }

      applyFilter(targetFilter, true);
    });

    btn.addEventListener('keydown', (e) => {
      let nextIndex = null;
      if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
        nextIndex = (index + 1) % filterBtns.length;
      } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
        nextIndex = (index - 1 + filterBtns.length) % filterBtns.length;
      } else if (e.key === 'Home') {
        nextIndex = 0;
      } else if (e.key === 'End') {
        nextIndex = filterBtns.length - 1;
      }

      if (nextIndex !== null) {
        e.preventDefault();
        filterBtns[nextIndex].focus();
        filterBtns[nextIndex].click();
      }
    });
  });

  // Listen to browser forward/back hash navigation
  window.addEventListener('hashchange', () => {
    const hashFilter = getValidFilterFromHash();
    if (hashFilter !== activeFilter) {
      applyFilter(hashFilter, true);
    }
  });

  // Initial state on page load based on URL hash
  const initialFilter = getValidFilterFromHash();
  applyFilter(initialFilter, false);
}
