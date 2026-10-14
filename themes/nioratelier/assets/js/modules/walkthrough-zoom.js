/**
 * Cinematic Scroll-Driven Walkthrough Zoom Hero
 * Fluid Scroll-Linked Spatial Crossfade & 3D Depth Transitions
 */

export function initWalkthroughZoom() {
  const canvas = document.getElementById('niorWalkthroughCanvas');
  const track = document.getElementById('niorWalkthroughHeroTrack');
  if (!canvas || !track) return;

  const { gsap, ScrollTrigger, niorConfig } = window;
  if (!gsap || !ScrollTrigger) return;

  const themeUri = (niorConfig && niorConfig.themeUri) ? niorConfig.themeUri : '';
  const totalFrames = 9;

  // Spatial Zone Tags for the architectural HUD indicator (9 curated zones)
  const zoneTags = [
    'ATRIUM PORTAL',
    'CENTRAL ROTUNDA',
    'VELVET LOUNGE',
    'LINEAR BAR & MILLWORK',
    'BRONZE ARCHWAY',
    'MEZZANINE GALLERY',
    'PRIVATE CELLAR',
    'SALON FINALE',
    'V-STAGE FINALE',
  ];

  // Resolve image paths (frame-01.jpg to frame-09.jpg)
  const imageSources = (niorConfig && niorConfig.walkthroughImages && niorConfig.walkthroughImages.length === totalFrames)
    ? niorConfig.walkthroughImages
    : Array.from({ length: totalFrames }, (_, i) => {
        const num = String(i + 1).padStart(2, '0');
        return `${themeUri}/assets/img/walkthrough/frame-${num}.jpg`;
      });

  const context = canvas.getContext('2d', { alpha: false, desynchronized: true });
  if (context) {
    context.imageSmoothingEnabled = true;
    context.imageSmoothingQuality = 'high';
  }
  const images = [];
  let isPrimed = false;

  // DOM Elements
  const brandEl = document.getElementById('niorWalkthroughBrand');
  const contentEl = document.getElementById('niorWalkthroughContent');
  const hudEl = document.getElementById('niorWalkthroughHUD');
  const frameNumEl = document.getElementById('niorWalkthroughFrameNum');
  const totalEl = hudEl ? hudEl.querySelector('.nior-walkthrough-hud__total') : null;
  const zoneTagEl = document.getElementById('niorWalkthroughZoneTag');
  const progressFillEl = document.getElementById('niorWalkthroughProgressFill');
  const scrollHintEl = document.getElementById('niorWalkthroughScrollHint');
  const growDotEl = document.getElementById('niorHeroGrowDot');
  const growDiscEl = document.getElementById('niorHeroGrowDisc');
  const stageEl = track.querySelector('.nior-walkthrough-hero-stage');

  let maxDiscScale = 40;

  /**
   * Calculate precise dot coordinates and maximum scale to engulf the stage
   */
  function updateDiscOrigin() {
    if (!growDotEl || !growDiscEl || !stageEl) return;
    const stageRect = stageEl.getBoundingClientRect();
    const dotRect = growDotEl.getBoundingClientRect();

    let currentBrandY = 0;
    if (brandEl && brandEl.style.transform) {
      const match = brandEl.style.transform.match(/translateY\(([-\d.]+)px\)/);
      if (match) currentBrandY = parseFloat(match[1]) || 0;
    }

    const dotCenterX = dotRect.left + dotRect.width / 2;
    const dotCenterY = (dotRect.top + dotRect.height / 2) - currentBrandY;

    const originX = dotCenterX - stageRect.left;
    const originY = dotCenterY - stageRect.top;

    growDiscEl.style.left = `${originX.toFixed(1)}px`;
    growDiscEl.style.top = `${originY.toFixed(1)}px`;

    const stageW = stageRect.width || window.innerWidth;
    const stageH = stageRect.height || window.innerHeight;
    const d1 = Math.hypot(originX, originY);
    const d2 = Math.hypot(stageW - originX, originY);
    const d3 = Math.hypot(originX, stageH - originY);
    const d4 = Math.hypot(stageW - originX, stageH - originY);
    const maxRadius = Math.max(d1, d2, d3, d4);

    // Base diameter is 60px (base radius is 30px)
    maxDiscScale = (maxRadius / 30) * 1.08;
  }

  // Synchronize HUD total frames display dynamically
  if (totalEl) {
    totalEl.textContent = String(totalFrames).padStart(2, '0');
  }

  // Animation scrub state
  const state = {
    progress: 0,
  };

  /**
   * Resize Canvas Buffer (called on mount and debounced resize only)
   * Avoids expensive GPU texture reallocations during active scroll frames.
   */
  function resizeCanvas() {
    const dpr = Math.min(window.devicePixelRatio || 1, 2);
    const width = window.innerWidth;
    const height = window.innerHeight;

    const targetW = Math.floor(width * dpr);
    const targetH = Math.floor(height * dpr);

    if (canvas.width !== targetW || canvas.height !== targetH) {
      canvas.width = targetW;
      canvas.height = targetH;
      canvas.style.width = `${width}px`;
      canvas.style.height = `${height}px`;
    }

    if (context) {
      context.imageSmoothingEnabled = true;
      context.imageSmoothingQuality = 'high';
    }
  }

  // Preload and decode walkthrough frames in parallel
  imageSources.forEach((src, index) => {
    const img = new Image();
    img.src = src;

    const onReady = () => {
      if (index === 0 && !isPrimed) {
        isPrimed = true;
        resizeCanvas();
        render(0);
      }
    };

    img.onload = () => {
      if (typeof img.decode === 'function') {
        img.decode().then(onReady).catch(onReady);
      } else {
        onReady();
      }
    };

    images.push(img);
  });

  /**
   * High-Performance Cover-Fit Draw with Center Scaling
   */
  function drawCoverImage(img, scale = 1, alpha = 1) {
    if (!img || !img.complete || img.naturalWidth === 0 || alpha <= 0.001) return;

    const cw = canvas.width;
    const ch = canvas.height;
    const iw = img.naturalWidth;
    const ih = img.naturalHeight;

    // Cover aspect ratio multiplier
    const hRatio = cw / iw;
    const vRatio = ch / ih;
    const baseRatio = Math.max(hRatio, vRatio);

    const drawW = iw * baseRatio * scale;
    const drawH = ih * baseRatio * scale;
    const dx = (cw - drawW) * 0.5;
    const dy = (ch - drawH) * 0.5;

    context.globalAlpha = Math.max(0, Math.min(1, alpha));
    context.drawImage(img, dx, dy, drawW, drawH);
  }

  // Cinematic scroll budget allocation:
  // p: 0.00 -> 0.70 : Fluid spatial camera fly-through zooming through rooms 1-9
  // p: 0.70 -> 0.78 : Solid hold on room 9 finale with brand emblem & tagline fully settled
  // p: 0.78 -> 1.00 : Primary dot between "Architecture" and "Design" expands to engulf the stage
  const walkthroughProgressEnd = 0.70;
  const brandSettleEnd = 0.78;

  /**
   * Continuous Scroll-Driven Walkthrough Spatial Transitions
   * Smoothly transitions images from one room to another as the user scrolls,
   * with subtle cinematic depth and zero magnetic scroll-jacking.
   */
  function render(progress) {
    const clampedP = Math.max(0, Math.min(1, progress));
    const totalTransitions = totalFrames - 1; // 8 intervals for 9 frames

    // Map progress to spatial transitions
    const spatialP = Math.min(1, clampedP / walkthroughProgressEnd);
    const u = spatialP * totalTransitions; // Continuous coordinate [0.0 ... 8.0]

    // Reset canvas background
    context.globalAlpha = 1.0;
    context.fillStyle = '#0c0d0e';
    context.fillRect(0, 0, canvas.width, canvas.height);

    if (u >= totalTransitions) {
      const lastImg = images[totalFrames - 1];
      drawCoverImage(lastImg, 1.0, 1.0);
      updateUI(clampedP, totalFrames - 1, 1.0);
      return;
    }

    const currentIndex = Math.floor(u);
    const nextIndex = currentIndex + 1;
    const t = u - currentIndex; // Progress within interval [0.0 ... 1.0)

    const currentImg = images[currentIndex];
    const nextImg = images[nextIndex];

    // Smooth transition window:
    // t <= 0.12: Crisp initial room frame with gentle drift
    // 0.12 < t < 0.88: Fluid crossfade and depth zoom
    // t >= 0.88: Seamless arrival into the next solid room frame
    const fadeStart = 0.12;
    const fadeEnd = 0.88;

    if (t <= fadeStart) {
      const solidProgress = t / fadeStart;
      const currentScale = 1.0 + 0.015 * solidProgress;
      drawCoverImage(currentImg, currentScale, 1.0);
    } else if (t >= fadeEnd) {
      const arrivalProgress = (t - fadeEnd) / (1.0 - fadeEnd);
      const nextScale = 1.0 + 0.008 * arrivalProgress;
      drawCoverImage(nextImg, nextScale, 1.0);
    } else {
      const tau = (t - fadeStart) / (fadeEnd - fadeStart); // 0.0 ... 1.0
      // Smooth cubic ease curve for velvety crossfade
      const ease = tau * tau * (3 - 2 * tau);

      // Incoming room emerging from subtle depth
      const nextScale = 0.94 + 0.06 * ease;
      drawCoverImage(nextImg, nextScale, 1.0);

      // Current room pushing forward and dissolving smoothly
      const currentScale = 1.015 + 0.10 * ease;
      const currentAlpha = 1.0 - ease;
      drawCoverImage(currentImg, currentScale, currentAlpha);
    }

    // Reset canvas globalAlpha
    context.globalAlpha = 1.0;

    // Update UI HUD & Staged Overlays
    updateUI(clampedP, currentIndex, t);
  }

  function updateUI(p, activeIndex, t) {
    // 1. Staged reveal: Initial brand & headline fade out gracefully as scroll begins
    if (contentEl) {
      const contentAlpha = Math.max(0, 1 - p / 0.08);
      const contentY = -35 * (p / 0.08);
      contentEl.style.opacity = contentAlpha;
      contentEl.style.transform = `translateY(${contentY}px)`;
      contentEl.style.pointerEvents = contentAlpha <= 0.05 ? 'none' : 'auto';
    }

    // 2. Center brand emblem: Fades out initially, fades back in on room 9 finale,
    // and stays at 100% opacity while the expanding disc swallows it from the inside out!
    if (brandEl) {
      let brandAlpha = 0;
      let brandY = 0;

      if (p <= 0.07) {
        // Initial intro frame fade out
        const factor = p / 0.07;
        brandAlpha = Math.max(0, 1 - factor);
        brandY = -25 * factor;
      } else if (p >= 0.62 && p <= 0.72) {
        // Ending frame (frame 09) fade back in
        const factor = Math.min(1, Math.max(0, (p - 0.62) / 0.10));
        brandAlpha = factor;
        brandY = 25 * (1 - factor);
      } else if (p > 0.72) {
        // Fully settled on frame 9, stays visible until the expanding disc covers it
        brandAlpha = 1;
        brandY = 0;
      } else {
        brandAlpha = 0;
        brandY = -25;
      }

      brandEl.style.opacity = brandAlpha;
      brandEl.style.transform = `translateY(${brandY}px)`;
    }

    if (scrollHintEl) {
      scrollHintEl.style.opacity = p > 0.04 ? '0' : '1';
    }

    // 3. Minimalist Gold HUD: Activates smoothly on scroll, recedes on ending finale
    if (hudEl) {
      if (p > 0.04 && p < 0.72) {
        hudEl.classList.add('is-active');
      } else {
        hudEl.classList.remove('is-active');
      }
    }

    // Display frame advances when entering the second half of the transition
    const displayIndex = (t >= 0.50 && activeIndex < totalFrames - 1) ? activeIndex + 1 : activeIndex;

    if (frameNumEl) {
      const numStr = String(displayIndex + 1).padStart(2, '0');
      if (frameNumEl.textContent !== numStr) {
        frameNumEl.textContent = numStr;
      }
    }

    if (zoneTagEl) {
      const tag = zoneTags[displayIndex] || 'NIOR ATELIER';
      if (zoneTagEl.textContent !== tag) {
        zoneTagEl.textContent = tag;
      }
    }

    if (progressFillEl) {
      const spatialProgress = Math.min(1, p / walkthroughProgressEnd);
      progressFillEl.style.width = `${(spatialProgress * 100).toFixed(1)}%`;
    }

    // 4. Growing Obsidian Disc: Expands from the dot between "Architecture" and "Design",
    // swallowing the text and the entire hero stage into pure obsidian.
    if (growDiscEl) {
      if (p <= brandSettleEnd) {
        growDiscEl.style.transform = 'translate(-50%, -50%) scale(0)';
        growDiscEl.style.opacity = '0';
        growDiscEl.style.visibility = 'hidden';
      } else {
        // Dynamically ensure exact origin coordinates once brand text has settled
        if (!growDiscEl.dataset.aligned && p >= brandSettleEnd) {
          updateDiscOrigin();
          growDiscEl.dataset.aligned = 'true';
        }

        const expandT = Math.min(1, (p - brandSettleEnd) / (1.0 - brandSettleEnd));
        // Exponential deceleration curve for organic fluid bloom
        const ease = Math.pow(expandT, 1.8);
        const currentScale = ease * maxDiscScale;

        growDiscEl.style.visibility = 'visible';
        growDiscEl.style.opacity = '1';
        growDiscEl.style.transform = `translate(-50%, -50%) scale(${currentScale.toFixed(3)})`;
      }

      // Reset alignment cache flag when scrolling back up above the finale
      if (p < 0.70 && growDiscEl.dataset.aligned) {
        delete growDiscEl.dataset.aligned;
      }
    }
  }

  // Setup GSAP ScrollTrigger without magnetic auto-snap (Fluid natural scrub)
  const trigger = ScrollTrigger.create({
    trigger: track,
    start: 'top top',
    end: 'bottom bottom',
    scrub: true,
    onUpdate: (self) => {
      state.progress = self.progress;
      render(state.progress);
    },
  });

  // Debounced window resize handler
  let resizeTimer = null;
  const onResize = () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      resizeCanvas();
      updateDiscOrigin();
      render(state.progress);
      ScrollTrigger.refresh();
    }, 120);
  };
  window.addEventListener('resize', onResize, { passive: true });

  // Initial trigger refresh once images load
  setTimeout(() => {
    resizeCanvas();
    updateDiscOrigin();
    ScrollTrigger.refresh();
    render(0);
  }, 180);
}
