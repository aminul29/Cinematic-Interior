/**
 * Nior Atelier Main Script Orchestrator
 * Entry ES Module loading all specialized components.
 */

import { initSmoothScroll } from './modules/smooth-scroll.js?v=1.8.41';
import { initPreloader } from './modules/preloader.js?v=1.8.41';
import { initHeroCanvas } from './modules/hero-canvas.js?v=1.8.41';
import { initVideoScrub } from './modules/video-scrub.js?v=1.8.41';
import { initWalkthroughZoom } from './modules/walkthrough-zoom.js?v=1.8.41';
import { initFallingLogos } from './modules/falling-logos.js?v=1.8.41';
import { initRackFocus } from './modules/rack-focus.js?v=1.8.41';
import { initKineticIngress } from './modules/kinetic-ingress.js?v=1.8.41';
import { initProjectGallery } from './modules/project-gallery.js?v=1.8.41';

document.addEventListener('DOMContentLoaded', () => {
  // 1. Initialize buttery-smooth Lenis scrolling
  initSmoothScroll();

  // 2. Initialize interactive project portfolio galleries & fullscreen lightbox
  initProjectGallery();

  // 3. Initialize architectural counter preloader (0-100%)
  initPreloader(() => {
    // 4. Initialize hero media layers (Canvas, Video scrub, or Walkthrough Zoom depending on active pattern)
    initHeroCanvas();
    initVideoScrub();
    initWalkthroughZoom();

    // 5. Initialize Apple-style rack-focus word typography
    initRackFocus();

    // 6. Initialize client logos physics drop animation
    initFallingLogos();

    // 7. Initialize two-way 3D kinetic ingress for cards and sections
    initKineticIngress();
  });
});

