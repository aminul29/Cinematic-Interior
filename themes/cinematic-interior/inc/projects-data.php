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
    $version  = defined( 'CINEMATIC_INTERIOR_VERSION' ) ? CINEMATIC_INTERIOR_VERSION : '1.0.0';
    $urls     = array();
    for ( $i = 1; $i <= $count; $i++ ) {
        $urls[] = sprintf( '%s/%02d.jpg?v=%s', $base_uri, $i, rawurlencode( $version ) );
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
            'id'          => 'commercial',
            'number'      => '01',
            'eyebrow'     => 'Corporate & Exhibition',
            'title'       => 'Commercial Projects',
            'description' => 'Purposeful environments that unite brand identity, functionality and customer experience.',
            'projects'    => array(
                array(
                    'slug'        => 'bradbury-office',
                    'title'       => 'Bradbury Office',
                    'category'    => 'Corporate Workspace',
                    'description' => 'Polished marble reception, acoustic glass partitions, and bespoke executive suites.',
                    'count'       => 5,
                ),
                array(
                    'slug'        => 'ceva-logistics',
                    'title'       => 'CEVA Logistics Hub',
                    'category'    => 'Logistics & Operations Center',
                    'description' => 'High-efficiency logistics offices, dynamic circulation spine, and ergonomic command centers.',
                    'count'       => 10,
                ),
                array(
                    'slug'        => 'dasher',
                    'title'       => 'Dasher Headquarters',
                    'category'    => 'Tech & Creative Office',
                    'description' => 'Industrial chic open plan, acoustic baffle ceilings, and collaborative breakout pods.',
                    'count'       => 8,
                ),
                array(
                    'slug'        => 'jome',
                    'title'       => 'Jome Experience Space',
                    'category'    => 'Brand Showroom & Workspace',
                    'description' => 'Architectural arches, curated warm neutral tones, and ambient linear illumination.',
                    'count'       => 10,
                ),
                array(
                    'slug'        => 'lumiere-bi-skin',
                    'title'       => 'Lumière Bi Skin',
                    'category'    => 'Aesthetic & Wellness Clinic',
                    'description' => 'Minimalist organic curves, fluted champagne portals, and soft indirect lighting.',
                    'count'       => 8,
                ),
                array(
                    'slug'        => 'executive-office-interior',
                    'title'       => 'Apex Executive Suites',
                    'category'    => 'Executive Workspace',
                    'description' => 'Monolithic marble desks, floor-to-ceiling glass pavilions, and custom linear joinery.',
                    'count'       => 11,
                ),
                array(
                    'slug'        => 'corporate-showroom',
                    'title'       => 'FinTech & Sports Pavilion',
                    'category'    => 'Exhibition Center',
                    'description' => 'Cobalt LED ribbons and biophilic executive lounge zones.',
                    'count'       => 12,
                ),
            ),
        ),
        array(
            'id'          => 'fnb-hospitality',
            'number'      => '02',
            'eyebrow'     => 'Dining · Nightlife',
            'title'       => 'F&B & Hospitality',
            'description' => 'Inviting destinations that bring together atmosphere, spatial planning and brand identity to create meaningful customer experiences.',
            'projects'    => array(
                array(
                    'slug'        => 'guang-restaurant-bar',
                    'title'       => 'Guang Restaurant & Bar',
                    'category'    => 'Contemporary Dining & Bar',
                    'description' => 'Emerald glazed tiles, sculptural koi bar counter, and warm timber lattice ceilings.',
                    'count'       => 6,
                ),
                array(
                    'slug'        => 'lucha-loco',
                    'title'       => 'Lucha Loco',
                    'category'    => 'Vibrant Dining & Cocktail Bar',
                    'description' => 'Tropical courtyard greenery, neon-infused cocktail bar, and intimate leather booth seating.',
                    'count'       => 9,
                ),
                array(
                    'slug'        => 'vstage-lounge',
                    'title'       => 'V Stage Lounge',
                    'category'    => 'Entertainment Lounge',
                    'description' => 'Immersive nightlife environment built around a commanding central stage and layered lighting.',
                    'count'       => 10,
                ),
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
            'id'          => 'retail-mall',
            'number'      => '03',
            'eyebrow'     => 'Retail & Flagships',
            'title'       => 'Retail & Shopping Mall',
            'description' => 'Distinctive retail environments designed around visual identity, customer journeys and memorable shopping experiences.',
            'projects'    => array(
                array(
                    'slug'        => 'dreame',
                    'title'       => 'Dreame Innovation Store',
                    'category'    => 'Smart Tech Flagship',
                    'description' => 'Futuristic metallic portals, halo-lit display pedestals, and streamlined customer flow.',
                    'count'       => 10,
                ),
                array(
                    'slug'        => 'hm',
                    'title'       => 'H&M Flagship Store',
                    'category'    => 'Fashion Retail Concept',
                    'description' => 'Spacious illuminated navigation portals, terrazzo flooring, and warm timber accents.',
                    'count'       => 12,
                ),
                array(
                    'slug'        => 'mac-cosmetics',
                    'title'       => 'MAC Cosmetics Boutique',
                    'category'    => 'Luxury Beauty Boutique',
                    'description' => 'High-contrast monochrome makeup stations, bespoke mirror lighting, and gloss black joinery.',
                    'count'       => 8,
                ),
                array(
                    'slug'        => 'ralph-lauren',
                    'title'       => 'Ralph Lauren Flagship',
                    'category'    => 'Haute Couture & Heritage Retail',
                    'description' => 'Mahogany millwork, brass detailing, and classic American heritage salon atmosphere.',
                    'count'       => 11,
                ),
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
            'id'          => 'residential',
            'number'      => '04',
            'eyebrow'     => 'Living & Estates',
            'title'       => 'Residential & Villas',
            'description' => 'Thoughtfully designed living spaces that balance comfort, character, materiality and functionality.',
            'projects'    => array(
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
