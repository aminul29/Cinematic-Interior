<?php
/**
 * Title: Cinematic Video Scrub Hero
 * Slug: nioratelier/hero-video-scrub
 * Categories: nior-cinematic
 * Description: Hardware-accelerated rAF video scrubbing hero with staged luxury typography and poster fallback.
 */
?>
<!-- wp:html -->
<section id="niorVideoHeroTrack" class="nior-video-hero-track" aria-label="Cinematic Interior Architecture Walkthrough">
  <div class="nior-video-hero-stage">
    
    <div id="niorVideoMediaContainer" class="nior-video-hero-media">
      <picture>
        <source srcset="<?php echo esc_url( get_theme_file_uri( '/assets/img/hero-poster.webp' ) ); ?>" type="image/webp" />
        <img id="niorVideoHeroPoster" class="nior-video-hero-poster" src="<?php echo esc_url( get_theme_file_uri( '/assets/img/hero-poster.jpg' ) ); ?>" alt="Nior Atelier Architectural Interior" loading="eager" fetchpriority="high" />
      </picture>
      <video id="niorVideoHeroPlayer" class="nior-video-hero-player" playsinline muted preload="auto" webkit-playsinline></video>
      <div class="nior-video-scrim-dark"></div>
      <div class="nior-video-scrim-radial"></div>
      <div class="nior-video-scrim-vignette"></div>
    </div>

    <div id="niorHeroCenterBrand" class="nior-hero-center-brand">
      <div class="nior-hero-center-brand__title">NIOR ATELIER</div>
      <div class="nior-hero-center-brand__divider"></div>
      <div class="nior-hero-center-brand__tagline">Architecture · Design · Build</div>
    </div>

    <div class="nior-video-hero-content">
      <div class="nior-container">
        <div class="nior-video-hero-ui-container">
          <div class="nior-hero-badge">
            <span class="nior-eyebrow">Company Profile 2026</span>
          </div>

          <h1 class="nior-hero-headline">
            Crafting <span class="nior-text-gold">Cinematic Spaces</span><br />
            That Perform.
          </h1>

          <p class="nior-hero-sub">
            Uniting architecture, custom fabrication, and spatial performance to craft unforgettable environments.
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

    <div class="nior-hero-scroll-prompt">
      <span>Scroll To Enter</span>
      <div class="nior-scroll-line"></div>
    </div>

  </div>
</section>
<!-- /wp:html -->
