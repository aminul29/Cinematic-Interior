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
$all_projects       = nioratelier_get_all_portfolio_projects();
$total_all_projects = count( $all_projects );
?>
<!-- wp:html -->
<div class="nior-page-hero nior-page-hero--projects nior-projects-hero" style="background-image: linear-gradient(180deg, rgba(12, 13, 14, 0.40) 0%, rgba(12, 13, 14, 0.65) 100%), url('<?php echo esc_url( get_theme_file_uri( '/assets/img/our-projects-banner-bg.webp' ) ); ?>');">
  <div class="nior-container">
    <div class="nior-page-hero__inner">
      <span class="nior-eyebrow">Selected Works</span>
      <h1>Every Space Begins With A Purpose.</h1>
      <p class="nior-lead">
        Our projects explore how design, materials, lighting and spatial planning come together to shape environments that connect with people and communicate identity. Explore our work across commercial, retail, F&amp;B, hospitality and residential spaces.
      </p>
    </div>
  </div>
</div>

<section id="portfolio-archive" class="nior-section nior-section--surface nior-portfolio-unified">
  <div class="nior-container">
    <div class="nior-portfolio-filter-bar" role="toolbar" aria-label="Portfolio Sector Filters">
      <div class="nior-portfolio-filter-tabs" role="tablist" aria-label="Project Categories">
        <button
          type="button"
          class="nior-filter-btn is-active"
          role="tab"
          aria-selected="true"
          data-filter="all"
          id="tab-all"
        >
          <span class="nior-filter-btn__label">All</span>
          <span class="nior-filter-btn__count">(<?php echo esc_html( $total_all_projects ); ?>)</span>
        </button>
        <?php foreach ( $portfolio_sections as $sec ) :
          $sec_count = count( $sec['projects'] );
        ?>
          <button
            type="button"
            class="nior-filter-btn"
            role="tab"
            aria-selected="false"
            data-filter="<?php echo esc_attr( $sec['id'] ); ?>"
            id="tab-<?php echo esc_attr( $sec['id'] ); ?>"
          >
            <span class="nior-filter-btn__num"><?php echo esc_html( $sec['number'] ); ?></span>
            <span class="nior-filter-btn__label"><?php echo esc_html( $sec['title'] ); ?></span>
            <span class="nior-filter-btn__count">(<?php echo esc_html( $sec_count ); ?>)</span>
          </button>
        <?php endforeach; ?>
      </div>

      <div class="nior-portfolio-filter-status" aria-live="polite">
        <span class="nior-portfolio-filter-counter">
          Showing <strong class="nior-filter-count-current"><?php echo esc_html( $total_all_projects ); ?></strong> of <?php echo esc_html( $total_all_projects ); ?> Projects
        </span>
      </div>
    </div>

    <div class="nior-portfolio-grid" id="portfolio-grid">
      <?php
      foreach ( $all_projects as $project ) :
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
            data-sector="<?php echo esc_attr( $project['sector_id'] ); ?>"
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
              <div class="nior-portfolio-card__meta">
                <span class="nior-portfolio-card__sector-tag"><?php echo esc_html( $project['sector_title'] ); ?></span>
                <span class="nior-portfolio-card__category"><?php echo esc_html( $project['category'] ); ?></span>
              </div>
              <h3><?php echo esc_html( $project['title'] ); ?></h3>
              <?php if ( ! empty( $project['description'] ) ) : ?>
                <p><?php echo esc_html( $project['description'] ); ?></p>
              <?php endif; ?>

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
