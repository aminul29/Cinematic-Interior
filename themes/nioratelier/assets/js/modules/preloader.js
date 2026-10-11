/**
 * Luxury Architectural Counter Preloader & Navigation Interactivity
 */

export function initPreloader(onComplete) {
  const preloader = document.getElementById('niorPreloader');
  const counterEl = document.getElementById('niorPreloaderCount');
  const fillEl = document.getElementById('niorPreloaderFill');
  const progressBar = document.getElementById('niorTopProgressBar');

  let currentPercent = 0;
  const targetPercent = 100;
  const startTime = performance.now();
  const duration = 1200; // 1.2s smooth minimum loading time

  function update() {
    const elapsed = performance.now() - startTime;
    const progress = Math.min(elapsed / duration, 1);
    currentPercent = Math.floor(progress * targetPercent);

    if (counterEl) {
      counterEl.textContent = `${String(currentPercent).padStart(2, '0')}%`;
    }

    if (fillEl) {
      fillEl.style.width = `${currentPercent}%`;
    }

    if (progress < 1) {
      requestAnimationFrame(update);
    } else {
      if (preloader) {
        preloader.classList.add('is-revealing');
        setTimeout(() => {
          preloader.classList.add('is-loaded');
          if (typeof onComplete === 'function') {
            onComplete();
          }
        }, 600);
      } else if (typeof onComplete === 'function') {
        onComplete();
      }
    }
  }

  requestAnimationFrame(update);

  // Global top scroll progress bar
  if (progressBar) {
    window.addEventListener('scroll', () => {
      const scrollHeight = document.documentElement.scrollHeight - window.innerHeight;
      if (scrollHeight > 0) {
        const p = Math.max(0, Math.min(1, window.scrollY / scrollHeight));
        progressBar.style.transform = `scaleX(${p})`;
      }
    }, { passive: true });
  }

  // Header scroll appearance
  const header = document.querySelector('.nior-header');
  if (header) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 40) {
        header.classList.add('is-scrolled');
      } else {
        header.classList.remove('is-scrolled');
      }
    }, { passive: true });
  }

  // Header logo recovery fallback for cross-environment directory discrepancies
  const headerLogo = document.querySelector('.nior-header__logo-img');
  if (headerLogo && window.niorConfig?.themeUri) {
    headerLogo.addEventListener('error', () => {
      const targetSrc = `${window.niorConfig.themeUri}/assets/img/logo-cropped.webp`;
      if (headerLogo.src !== targetSrc) {
        headerLogo.src = targetSrc;
      }
    }, { once: true });
  }

  // Mobile drawer toggle
  const toggleBtn = document.getElementById('niorMobileToggle');
  const mobileDrawer = document.getElementById('niorMobileDrawer');
  if (toggleBtn && mobileDrawer) {
    toggleBtn.addEventListener('click', () => {
      const isOpen = mobileDrawer.classList.toggle('is-open');
      toggleBtn.classList.toggle('is-open', isOpen);
      toggleBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
  }

  // Active navigation link highlighting
  const currentPath = window.location.pathname.replace(/\/+$/, '') || '/';
  document.querySelectorAll('.nior-header__nav-link, .nior-mobile-menu__nav a').forEach((link) => {
    const linkPath = new URL(link.href, window.location.origin).pathname.replace(/\/+$/, '') || '/';
    if (linkPath === currentPath) {
      link.classList.add('is-active');
    } else {
      link.classList.remove('is-active');
    }
  });
}
