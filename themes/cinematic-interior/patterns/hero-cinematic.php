<?php
/**
 * Title: Cinematic Hero Walkthrough
 * Slug: cinematic-interior/hero-cinematic
 * Categories: nior-cinematic
 * Description: Sticky 380vh canvas walkthrough scrubbing with staged luxury typography and preloader.
 */
?>
<!-- wp:html -->
<!-- Architectural Counter Preloader -->
<div id="niorPreloader" class="nior-preloader" aria-hidden="true">
  <div class="nior-preloader__shutter">
    <div class="nior-preloader__shutter-panel"></div>
    <div class="nior-preloader__shutter-panel"></div>
  </div>
  <div class="nior-preloader__inner">
    <div class="nior-preloader__logo-circle">
      <svg class="nior-preloader__circle-svg" viewBox="0 0 250 250" aria-hidden="true">
        <circle class="nior-preloader__circle-track" cx="125" cy="125" r="116" />
        <circle id="niorPreloaderCircleFill" class="nior-preloader__circle-fill" cx="125" cy="125" r="116" />
      </svg>
      <img
        class="nior-preloader__logo-img"
        src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo-cropped.webp' ); ?>"
        alt="Nior Atelier"
        width="180"
        height="111"
        loading="eager"
        decoding="sync"
      />
    </div>
    <div id="niorPreloaderCount" class="nior-preloader__counter">00%</div>
  </div>
</div>

<!-- Global Top Progress Indicator -->
<div class="nior-top-progress" aria-hidden="true">
  <div id="niorTopProgressBar" class="nior-top-progress__bar"></div>
</div>

<!-- Sticky Cinematic Hero Track -->
<section id="niorHeroTrack" class="nior-hero-track" aria-label="Cinematic Interior Walkthrough">
  <div class="nior-hero-stage">
    
    <!-- Background Media Layers -->
    <div class="nior-hero-media">
      <canvas id="niorHeroCanvas" class="nior-hero-canvas"></canvas>
      <video id="niorHeroVideo" class="nior-hero-video" loop muted playsinline preload="auto">
        <source src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/walkthrough_master.mp4' ); ?>" type="video/mp4" />
      </video>
      <div class="nior-hero-scrim-dark"></div>
      <div class="nior-hero-scrim-radial"></div>
      <div class="nior-hero-scrim-vignette"></div>
    </div>

    <!-- Staged Typography Layer -->
    <div class="nior-hero-content">
      <div class="nior-container">
        <div class="nior-hero-ui-container">
          <div class="nior-hero-badge">
            <span class="nior-eyebrow">Company Profile 2026</span>
          </div>

          <h1 class="nior-hero-headline">
            Crafting <span class="nior-text-gold">Cinematic Spaces</span><br />
            That Perform.
          </h1>

          <p class="nior-hero-sub">
            Nior Atelier transforms spatial concepts into extraordinary environments. From central entertainment stages to bespoke hospitality and luxury residences, we unite architecture, craftsmanship, and business performance.
          </p>

          <div class="nior-hero-actions">
            <a href="#vstage" class="nior-btn">
              <span>Explore Featured Project</span>
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 7H13M13 7L7 1M13 7L7 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="nior-btn nior-btn--outline">
              <span>Start A Consultation</span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Floating Metrics Badge -->
    <div class="nior-hero-floating-card">
      <div class="nior-hero-floating-card__stat">
        <span class="nior-stat-num">11,000</span>
        <span class="nior-stat-label">SQ FT HQ & Factory</span>
      </div>
      <div class="nior-hero-floating-card__divider"></div>
      <div class="nior-hero-floating-card__stat">
        <span class="nior-stat-num">100%</span>
        <span class="nior-stat-label">In-House Execution</span>
      </div>
    </div>

    <!-- Scroll Prompt -->
    <div class="nior-hero-scroll-prompt">
      <span>Scroll To Enter</span>
      <div class="nior-scroll-line"></div>
    </div>

  </div>
</section>
<!-- /wp:html -->
