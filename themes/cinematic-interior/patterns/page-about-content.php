<?php
/**
 * Title: Page Content — About Us
 * Slug: cinematic-interior/page-about-content
 * Categories: nior-pages
 * Description: Complete editorial layout for the About Us page.
 */
?>
<!-- wp:html -->
<div class="nior-page-hero nior-page-hero--about" style="background-image: linear-gradient(180deg, rgba(12, 13, 14, 0.20) 0%, rgba(12, 13, 14, 0.32) 100%), url('<?php echo esc_url( get_theme_file_uri( '/assets/img/hq/factory-4.jpg' ) ); ?>');">
  <div class="nior-container">
    <div class="nior-page-hero__inner">
      <span class="nior-eyebrow">Studio Profile</span>
      <h1>Interior Architecture. Crafted In-House.</h1>
      <p class="nior-lead">
        Nior Atelier is an interior architecture, design and build studio creating distinctive spaces for brands, businesses and private clients across Malaysia and internationally.
      </p>
    </div>
  </div>
</div>

<section class="nior-section nior-section--surface">
  <div class="nior-container">
    <div class="nior-about-story">
      <div>
        <span class="nior-eyebrow">Our Story</span>
        <h2 style="font-size: clamp(2.2rem, 3.8vw, 3.4rem); margin-bottom: 24px;">Transforming Ideas Into Living Environments</h2>
        <p>
          We combine design, fabrication, and build under one unified creative direction.
        </p>
        <p>
          Every space we deliver is engineered to create experiences people remember.
        </p>
        <p>
          Our 11,000 sq ft JB factory gives us direct oversight from concept to reality.
        </p>
      </div>

      <div class="nior-about-manifesto">
        <blockquote>
          “We believe successful spaces sit at the intersection of design, emotion, behavior and value.”
        </blockquote>
        <cite>Nior Atelier Philosophy · 2026</cite>
      </div>
    </div>

    <div style="margin-top: 60px;">
      <span class="nior-eyebrow">Production Infrastructure</span>
      <h3 style="font-family: var(--font-serif); font-size: clamp(1.8rem, 3vw, 2.4rem); margin-bottom: 24px; color: var(--nior-white);">11,000 SQ FT Workshop & Joinery Factory</h3>
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
        <div style="border-radius: 8px; overflow: hidden; aspect-ratio: 16/10; background: var(--nior-surface);">
          <img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/hq/factory-1.jpg' ) ); ?>" alt="Nior Atelier Joinery & Fabrication Machinery" style="width: 100%; height: 100%; object-fit: cover; display: block;" loading="lazy" />
        </div>
        <div style="border-radius: 8px; overflow: hidden; aspect-ratio: 16/10; background: var(--nior-surface);">
          <img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/hq/factory-2.jpg' ) ); ?>" alt="Bespoke Metalwork & Millwork Assembly" style="width: 100%; height: 100%; object-fit: cover; display: block;" loading="lazy" />
        </div>
        <div style="border-radius: 8px; overflow: hidden; aspect-ratio: 16/10; background: var(--nior-surface);">
          <img src="<?php echo esc_url( get_theme_file_uri( '/assets/img/hq/factory-3.jpg' ) ); ?>" alt="Direct Material Procurement & Custom Finishing" style="width: 100%; height: 100%; object-fit: cover; display: block;" loading="lazy" />
        </div>
      </div>
    </div>

  </div>
</section>
<!-- /wp:html -->

<!-- wp:pattern {"slug":"cinematic-interior/value-pillars"} /-->
<!-- wp:pattern {"slug":"cinematic-interior/integrated-process"} /-->
<!-- wp:pattern {"slug":"cinematic-interior/why-nior"} /-->
<!-- wp:pattern {"slug":"cinematic-interior/cta-handover"} /-->

