<?php
/**
 * Nior Atelier Projects Portfolio & Gallery Dataset
 * Organizes all client project galleries into 4 curated sector categories.
 *
 * @package NiorAtelier
 * @since 1.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Helper to generate full gallery image URLs for a project folder.
 *
 * @param string $slug  Project directory slug under assets/img/projects/galleries/.
 * @param int    $count Total number of images in the folder.
 * @return array Array of escaped image URLs.
 */
function nioratelier_get_project_gallery_urls( $slug, $count ) {
    $base_uri = get_template_directory_uri() . '/assets/img/projects/galleries/' . $slug;
    $urls     = array();
    for ( $i = 1; $i <= $count; $i++ ) {
        $urls[] = sprintf( '%s/%02d.jpg', $base_uri, $i );
    }
    return $urls;
}

/**
 * Returns the categorized portfolio sections and project galleries.
 *
 * @return array
 */
function nioratelier_get_portfolio_sections() {
    return array(
        array(
            'id'          => 'fnb-hospitality',
            'number'      => '01',
            'eyebrow'     => 'Dining · Nightlife',
            'title'       => 'F&B & Hospitality',
            'description' => '',
            'projects'    => array(
                array(
                    'slug'        => 'genki-sushi',
                    'title'       => 'Genki Sushi',
                    'category'    => 'F&B Spatial Design',
                    'description' => 'Curved light canopy and fluted architectural joinery.',
                    'count'       => 6,
                ),
                array(
                    'slug'        => 'imperial-dining',
                    'title'       => 'Imperial Dining',
                    'category'    => 'VIP Dining',
                    'description' => 'Diamond-inlay wall paneling and emerald velvet seating.',
                    'count'       => 9,
                ),
                array(
                    'slug'        => 'four-fingers',
                    'title'       => '4Fingers',
                    'category'    => 'Fast Casual Concept',
                    'description' => 'Terracotta brick portals and custom neon brand signage.',
                    'count'       => 9,
                ),
                array(
                    'slug'        => 'vstage-lounge',
                    'title'       => 'V Stage Lounge',
                    'category'    => 'Entertainment Lounge',
                    'description' => 'Parametric acoustic soffits and central stage architecture.',
                    'count'       => 10,
                ),
                array(
                    'slug'        => 'artisanal-cafe',
                    'title'       => 'Artisanal Cafe',
                    'category'    => 'Japanese Cafe',
                    'description' => 'Chevron wood wainscoting and micro-cement finishes.',
                    'count'       => 9,
                ),
                array(
                    'slug'        => 'rose-velvet-lounge',
                    'title'       => 'Rose Velvet Lounge',
                    'category'    => 'Private Club',
                    'description' => 'Tufted leather seating and ambient hospitality lighting.',
                    'count'       => 10,
                ),
            ),
        ),
        array(
            'id'          => 'beauty-cosmetics',
            'number'      => '02',
            'eyebrow'     => 'Beauty & Wellness',
            'title'       => 'Beauty & Fragrance',
            'description' => '',
            'projects'    => array(
                array(
                    'slug'        => 'cle-de-peau',
                    'title'       => 'Clé de Peau Beauté',
                    'category'    => 'Flagship Boutique',
                    'description' => 'Champagne-gold fluted consultation pods and radiance niches.',
                    'count'       => 6,
                ),
                array(
                    'slug'        => 'aesop-atelier',
                    'title'       => 'Aesop Atelier',
                    'category'    => 'Botanical Retail',
                    'description' => 'Sculptural bent bamboo vaulting and organic timber joinery.',
                    'count'       => 10,
                ),
                array(
                    'slug'        => 'armani-beauty',
                    'title'       => 'Armani Beauty',
                    'category'    => 'Luxury Boutique',
                    'description' => 'High-gloss lacquer curved islands and crimson paneling.',
                    'count'       => 7,
                ),
                array(
                    'slug'        => 'acqua-di-parma',
                    'title'       => 'Acqua di Parma',
                    'category'    => 'Haute Parfumerie',
                    'description' => 'Italian travertine textures and arched fragrance niches.',
                    'count'       => 11,
                ),
                array(
                    'slug'        => 'artisan-salon',
                    'title'       => 'Artisan Salon',
                    'category'    => 'Wellness Studio',
                    'description' => 'LED-framed styling mirrors and cognac leather chairs.',
                    'count'       => 7,
                ),
            ),
        ),
        array(
            'id'          => 'fashion-luxury-retail',
            'number'      => '03',
            'eyebrow'     => 'Fashion & Fine Jewelry',
            'title'       => 'Fashion & Retail',
            'description' => '',
            'projects'    => array(
                array(
                    'slug'        => 'haute-menswear',
                    'title'       => 'Haute Menswear',
                    'category'    => 'Fashion Flagship',
                    'description' => 'Crimson barrisol ceiling lighting and black steel rigging.',
                    'count'       => 13,
                ),
                array(
                    'slug'        => 'amlife-wellness',
                    'title'       => 'AmLife Showroom',
                    'category'    => 'Wellness Showroom',
                    'description' => 'Slatted timber portals and sculptural lantern clusters.',
                    'count'       => 6,
                ),
                array(
                    'slug'        => 'laura-fashion',
                    'title'       => 'L\'Aura & BO',
                    'category'    => 'Multi-Brand Boutique',
                    'description' => 'Mosaic threshold tiling and high-CRI track illumination.',
                    'count'       => 12,
                ),
                array(
                    'slug'        => 'aethel-jewelry',
                    'title'       => 'Aethel Fine Jewelry',
                    'category'    => 'Haute Joaillerie',
                    'description' => 'Curved museum vitrines and relief-carved bronze bases.',
                    'count'       => 12,
                ),
            ),
        ),
        array(
            'id'          => 'showroom-residential',
            'number'      => '04',
            'eyebrow'     => 'Private & Corporate',
            'title'       => 'Corporate & Living',
            'description' => '',
            'projects'    => array(
                array(
                    'slug'        => 'corporate-showroom',
                    'title'       => 'FinTech & Sports Pavilion',
                    'category'    => 'Exhibition Center',
                    'description' => 'Cobalt LED ribbons and biophilic executive lounge zones.',
                    'count'       => 12,
                ),
                array(
                    'slug'        => 'pavilion-showhouse',
                    'title'       => 'Pavilion Showhouse',
                    'category'    => 'Luxury Residence',
                    'description' => 'Book-matched walnut walls and recessed cove illumination.',
                    'count'       => 10,
                ),
                array(
                    'slug'        => 'seaside-villa',
                    'title'       => 'Seaside Villa',
                    'category'    => 'Private Villa',
                    'description' => 'Cantilevered architectural volumes and oceanfront terrace.',
                    'count'       => 1,
                ),
            ),
        ),
    );
}

/**
 * Returns all portfolio projects across all sectors in a flattened array,
 * enriched with sector ID, sector number, and sector title.
 *
 * @return array
 */
function nioratelier_get_all_portfolio_projects() {
    $sections = nioratelier_get_portfolio_sections();
    $all      = array();

    foreach ( $sections as $section ) {
        foreach ( $section['projects'] as $project ) {
            $project['sector_id']     = $section['id'];
            $project['sector_number'] = $section['number'];
            $project['sector_title']  = $section['title'];
            $all[]                    = $project;
        }
    }

    return $all;
}
