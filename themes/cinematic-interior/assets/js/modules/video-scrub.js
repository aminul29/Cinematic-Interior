/**
 * Hardware-Accelerated Video Scrub Engine (GOP=8 / All-Intra)
 * Synchronized with page scroll via rAF LERP damping, watchdog lock,
 * in-memory streaming Blob preloader, and static poster fallback for mobile/reduced-motion.
 *
 * @module video-scrub
 */

export function initVideoScrub() {
  const heroTrack = document.getElementById('niorVideoHeroTrack');
  const video = document.getElementById('niorVideoHeroPlayer');
  const mediaContainer = document.getElementById('niorVideoMediaContainer');
  const poster = document.getElementById('niorVideoHeroPoster');

  if (!heroTrack || !video) return;

  const { gsap, ScrollTrigger, niorConfig } = window;
  if (!gsap || !ScrollTrigger) return;

  // 1. Mobile & prefers-reduced-motion check
  const isReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const isMobile = window.matchMedia('(max-width: 820px)').matches;

  if (isReducedMotion || isMobile) {
    // Keep high-resolution poster visible, disable video decode loop to save mobile battery and memory
    if (poster) {
      poster.style.opacity = '1';
    }
    initStagedIngress(heroTrack, true);
    return;
  }

  // 2. Video Scrub Configuration
  const videoSrc = (niorConfig && niorConfig.scrubVideo)
    ? niorConfig.scrubVideo
    : `${niorConfig?.themeUri || ''}/assets/img/hero-scrub.mp4`;

  const TOTAL_FRAMES = 240; // 10s @ 24fps
  let dur = 10.0;
  let cur = 0;
  let target = 0;
  let inflight = false;
  let lastSeekAt = 0;
  let isPrimed = false;
  let rafId = null;

  function clamp(val, min, max) {
    return Math.max(min, Math.min(max, val));
  }

  // 3. Compute scroll target decoupled from rendering
  function computeTarget() {
    const rect = heroTrack.getBoundingClientRect();
    const total = heroTrack.offsetHeight - window.innerHeight;
    if (total > 0) {
      target = clamp(-rect.top / total, 0, 1);
    }
  }

  // 4. Hardware Decoder Pipeline Priming
  function prime() {
    if (isPrimed) return;
    try {
      video.currentTime = 0.001;
    } catch {
      // Ignore initial seek exception
    }

    let done = false;
    function onFirstFrame() {
      if (done) return;
      done = true;
      reveal();
    }

    if ('requestVideoFrameCallback' in video) {
      video.requestVideoFrameCallback(onFirstFrame);
      const playPromise = video.play();
      if (playPromise && playPromise.then) {
        playPromise.then(() => video.pause()).catch(() => {});
      }
    } else {
      video.addEventListener('seeked', function handler() {
        video.removeEventListener('seeked', handler);
        onFirstFrame();
      });
    }

    // Failsafe reveal timeout
    setTimeout(reveal, 2000);
  }

  function reveal() {
    if (isPrimed) return;
    isPrimed = true;
    if (mediaContainer) {
      mediaContainer.classList.add('is-video-primed');
    }
    computeTarget();
    cur = target;
    rafId = requestAnimationFrame(tick);
  }

  // 5. Watchdog-Protected Seek Loop
  video.addEventListener('loadedmetadata', () => {
    if (video.duration && Number.isFinite(video.duration)) {
      dur = video.duration;
    }
  });

  video.addEventListener('seeked', () => {
    inflight = false;
  });

  video.addEventListener('canplay', () => {
    if (!isPrimed) prime();
  });

  function tick(now) {
    now = now || performance.now();

    // Exponential LERP damping for velvety mousewheel and trackpad response
    cur += (target - cur) * 0.15;
    const t = clamp(cur * dur, 0, dur - 0.001);

    // 140ms Watchdog: reset stuck seeks under heavy CPU / GPU load
    if (inflight && now - lastSeekAt > 140) {
      inflight = false;
    }

    // Half-frame delta threshold: prevents saturating decoder queue with redundant micro-seeks
    const frameDelta = (dur / TOTAL_FRAMES) * 0.5;
    if (!inflight && Math.abs(t - video.currentTime) > frameDelta) {
      inflight = true;
      lastSeekAt = now;
      try {
        video.currentTime = t;
      } catch {
        inflight = false;
      }
    }

    rafId = requestAnimationFrame(tick);
  }

  // 6. In-Memory Streaming Blob Preloader (Eliminates HTTP 206 byte-range latency)
  function loadVideoBlob(url) {
    fetch(url)
      .then((res) => {
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return res.blob();
      })
      .then((blob) => {
        const blobUrl = URL.createObjectURL(blob);
        video.src = blobUrl;
        video.load();
      })
      .catch(() => {
        // Fallback to direct URL streaming
        video.src = url;
        video.load();
      });
  }

  loadVideoBlob(videoSrc);

  window.addEventListener('scroll', computeTarget, { passive: true });
  window.addEventListener('resize', computeTarget, { passive: true });

  // 7. Staged Scroll-Driven Typography Ingress Timeline
  initStagedIngress(heroTrack, false);
}

/**
 * Initializes GSAP ScrollTrigger timeline for staged luxury typography reveal.
 */
function initStagedIngress(heroTrack, isStatic) {
  const { gsap, ScrollTrigger } = window;
  if (!gsap || !ScrollTrigger) return;

  if (isStatic) {
    // For mobile/reduced-motion: animate once on entry without pinning
    gsap.to('.nior-hero-badge, .nior-hero-headline, .nior-hero-sub, .nior-hero-actions', {
      opacity: 1,
      y: 0,
      duration: 0.8,
      stagger: 0.15,
      ease: 'power2.out',
    });
    return;
  }

  const tl = gsap.timeline({
    scrollTrigger: {
      trigger: heroTrack,
      start: 'top top',
      end: '+=1800',
      scrub: 0.8,
    },
  });

  // Stage 0: Center Brand Title Card Dissolves & Glides Upward as Scrub Commences
  tl.to('#niorHeroCenterBrand', { opacity: 0, y: -45, scale: 0.96, duration: 0.12, ease: 'power2.inOut' }, 0);
  tl.to('.nior-hero-scroll-prompt', { opacity: 0, duration: 0.08 }, 0.04);

  // Stage 1: Status Badge
  tl.to('.nior-hero-badge', { opacity: 1, y: 0, duration: 0.15 }, 0.08);

  // Stage 2: Main Headline
  tl.to('.nior-hero-headline', { opacity: 1, y: 0, scale: 1, duration: 0.22 }, 0.16);

  // Stage 3: Subtitle & CTA Group
  tl.to('.nior-hero-sub', { opacity: 1, y: 0, duration: 0.18 }, 0.30);
  tl.to('.nior-hero-actions', { opacity: 1, y: 0, duration: 0.18 }, 0.35);

  // Stage 4: Floating Metrics Card
  tl.to('.nior-hero-floating-card', { opacity: 1, y: 0, scale: 1, duration: 0.22 }, 0.45);

  // Stage 5: Interface Hold
  tl.to({}, { duration: 0.15 }, 0.65);

  // Stage 6: Clean Upward Glissando Before Next Section Arrives
  tl.to('.nior-video-hero-ui-container', { y: -70, opacity: 0, duration: 0.18, ease: 'power2.in' }, 0.82);
  tl.to('.nior-hero-floating-card', { y: -40, opacity: 0, duration: 0.15, ease: 'power2.in' }, 0.85);

  // Stage 7: Finale Brand Reveal on ending frame
  tl.to('#niorHeroCenterBrand', { opacity: 1, y: 0, scale: 1, duration: 0.15, ease: 'power2.out' }, 0.88);
}
