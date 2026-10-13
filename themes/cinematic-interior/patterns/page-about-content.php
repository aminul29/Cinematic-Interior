<?php
/**
 * Title: Page Content — About Us
 * Slug: cinematic-interior/page-about-content
 * Categories: nior-pages
 * Description: Complete editorial layout for the About Us page.
 */
?>
<!-- wp:html -->
<div class="nior-page-hero">
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
          We combine creative direction, spatial design and technical execution to transform ideas into environments that are visually compelling, commercially purposeful and built to last.
        </p>
        <p>
          From concept development to final completion, we bring together design thinking, materiality, lighting, functionality and construction to create spaces that do more than look good — they create experiences people remember.
        </p>
        <p>
          Our 11,000 sq ft headquarters and furniture factory in Johor Bahru allows us to maintain direct oversight over custom millwork, metalwork, and bespoke architectural fixtures, ensuring our original artistic intent translates seamlessly into the physical realm.
        </p>
      </div>

      <div class="nior-about-manifesto">
        <blockquote>
          “We believe successful spaces sit at the intersection of design, emotion, behavior and value.”
        </blockquote>
        <cite>Nior Atelier Philosophy · 2026</cite>
      </div>
    </div>

    <!-- 11,000 SQ FT Production Facility Gallery -->
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

