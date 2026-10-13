<?php
/**
 * Title: Page Content — Projects Portfolio
 * Slug: cinematic-interior/page-projects-content
 * Categories: nior-pages
 * Description: Categorized multi-photo portfolio galleries and fullscreen lightbox for the Projects page.
 */

if ( ! function_exists( 'nioratelier_get_portfolio_sections' ) ) {
    require_once get_template_directory() . '/inc/projects-data.php';
}

$portfolio_sections = nioratelier_get_portfolio_sections();
?>
<!-- wp:html -->
<div class="nior-page-hero nior-projects-hero">
  <div class="nior-container">
    <div class="nior-page-hero__inner">
      <span class="nior-eyebrow">Selected Works &amp; Spatial Archives</span>
      <h1>Spaces That Perform.</h1>
      <p class="nior-lead">
        Explore our curated portfolio spanning flagship luxury retail, botanical apothecaries, Michelin-tier culinary destinations, high-energy entertainment lounges, and private estates. Select any project to inspect the full architectural gallery.
      </p>
      <nav class="nior-category-nav" aria-label="Project Sectors">
        <?php foreach ( $portfolio_sections as $sec ) : ?>
          <a href="#sector-<?php echo esc_attr( $sec['id'] ); ?>" class="nior-category-nav__pill">
            <span class="nior-category-nav__num"><?php echo esc_html( $sec['number'] ); ?></span>
            <span class="nior-category-nav__label"><?php echo esc_html( $sec['title'] ); ?></span>
          </a>
        <?php endforeach; ?>
      </nav>
    </div>
  </div>
</div>

<?php foreach ( $portfolio_sections as $sec_index => $section ) : ?>
<section id="sector-<?php echo esc_attr( $section['id'] ); ?>" class="nior-section nior-project-category-section <?php echo ( 0 === $sec_index % 2 ) ? 'nior-section--surface' : 'nior-section--obsidian'; ?>">
  <div class="nior-container">
    <header class="nior-category-header">
      <div class="nior-category-header__meta">
        <span class="nior-category-header__index"><?php echo esc_html( $section['number'] ); ?></span>
        <span class="nior-eyebrow"><?php echo esc_html( $section['eyebrow'] ); ?></span>
      </div>
      <div class="nior-category-header__main">
        <h2><?php echo esc_html( $section['title'] ); ?></h2>
        <p><?php echo esc_html( $section['description'] ); ?></p>
      </div>
    </header>

    <div class="nior-portfolio-grid">
      <?php
      foreach ( $section['projects'] as $project ) :
          $gallery_urls = nioratelier_get_project_gallery_urls( $project['slug'], $project['count'] );
          $cover_url    = ! empty( $gallery_urls[0] ) ? $gallery_urls[0] : '';
          $total_photos = count( $gallery_urls );
          $max_thumbs   = 4;
          $preview_urls = array_slice( $gallery_urls, 0, $max_thumbs );
          $extra_count  = max( 0, $total_photos - $max_thumbs );
          ?>
          <article
            class="nior-portfolio-card"
            tabindex="0"
            role="button"
            aria-label="<?php echo esc_attr( sprintf( 'Open %s gallery (%d photos)', $project['title'], $total_photos ) ); ?>"
            data-project-slug="<?php echo esc_attr( $project['slug'] ); ?>"
            data-project-title="<?php echo esc_attr( $project['title'] ); ?>"
            data-project-category="<?php echo esc_attr( $project['category'] ); ?>"
            data-project-desc="<?php echo esc_attr( $project['description'] ); ?>"
            data-project-gallery="<?php echo esc_attr( wp_json_encode( $gallery_urls ) ); ?>"
          >
            <div class="nior-portfolio-card__img-wrap">
              <img
                class="nior-portfolio-card__cover-img"
                src="<?php echo esc_url( $cover_url ); ?>"
                alt="<?php echo esc_attr( $project['title'] ); ?>"
                loading="lazy"
              />
              <div class="nior-portfolio-card__badge">
                <svg class="nior-portfolio-card__badge-icon" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                  <circle cx="8.5" cy="8.5" r="1.5"></circle>
                  <polyline points="21 15 16 10 5 21"></polyline>
                </svg>
                <span>View Gallery · <?php echo esc_html( $total_photos ); ?> <?php echo ( 1 === $total_photos ) ? 'Photo' : 'Photos'; ?></span>
              </div>
            </div>

            <div class="nior-portfolio-card__body">
              <span class="nior-portfolio-card__category"><?php echo esc_html( $project['category'] ); ?></span>
              <h3><?php echo esc_html( $project['title'] ); ?></h3>
              <p><?php echo esc_html( $project['description'] ); ?></p>

              <?php if ( $total_photos > 1 ) : ?>
                <div class="nior-portfolio-card__thumbs" aria-label="Gallery preview thumbnails">
                  <?php foreach ( $preview_urls as $thumb_idx => $thumb_url ) : ?>
                    <button
                      type="button"
                      class="nior-portfolio-card__thumb <?php echo ( 0 === $thumb_idx ) ? 'is-active' : ''; ?>"
                      data-photo-index="<?php echo esc_attr( $thumb_idx ); ?>"
                      data-photo-src="<?php echo esc_url( $thumb_url ); ?>"
                      aria-label="<?php echo esc_attr( sprintf( 'View photo %d of %s', $thumb_idx + 1, $project['title'] ) ); ?>"
                    >
                      <img src="<?php echo esc_url( $thumb_url ); ?>" alt="" loading="lazy" />
                    </button>
                  <?php endforeach; ?>

                  <?php if ( $extra_count > 0 ) : ?>
                    <button
                      type="button"
                      class="nior-portfolio-card__thumb nior-portfolio-card__thumb--more"
                      data-photo-index="<?php echo esc_attr( $max_thumbs ); ?>"
                      aria-label="<?php echo esc_attr( sprintf( 'View %d more photos', $extra_count ) ); ?>"
                    >
                      <span>+<?php echo esc_html( $extra_count ); ?></span>
                    </button>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            </div>
          </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endforeach; ?>

<div id="nior-project-lightbox" class="nior-lightbox" aria-hidden="true" role="dialog" aria-modal="true" aria-label="Project Image Gallery">
  <div class="nior-lightbox__backdrop" data-lightbox-close></div>
  <div class="nior-lightbox__dialog">
    <header class="nior-lightbox__header">
      <div class="nior-lightbox__meta">
        <span class="nior-lightbox__category"></span>
        <h3 class="nior-lightbox__title"></h3>
      </div>
      <div class="nior-lightbox__controls-top">
        <span class="nior-lightbox__counter">01 / 01</span>
        <button type="button" class="nior-lightbox__close" data-lightbox-close aria-label="Close gallery">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </button>
      </div>
    </header>

    <div class="nior-lightbox__stage">
      <button type="button" class="nior-lightbox__nav nior-lightbox__nav--prev" data-lightbox-prev aria-label="Previous photo">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
          <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
      </button>

      <figure class="nior-lightbox__figure">
        <img class="nior-lightbox__img" src="" alt="" />
        <figcaption class="nior-lightbox__caption"></figcaption>
      </figure>

      <button type="button" class="nior-lightbox__nav nior-lightbox__nav--next" data-lightbox-next aria-label="Next photo">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
          <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
      </button>
    </div>

    <div class="nior-lightbox__filmstrip-wrap">
      <div class="nior-lightbox__filmstrip" role="tablist" aria-label="Gallery Thumbnails"></div>
    </div>
  </div>
</div>
<!-- /wp:html -->

<!-- wp:pattern {"slug":"cinematic-interior/sectors-grid"} /-->
<!-- wp:pattern {"slug":"cinematic-interior/falling-logos"} /-->
<!-- wp:pattern {"slug":"cinematic-interior/cta-handover"} /-->
