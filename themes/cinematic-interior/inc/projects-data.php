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
            'eyebrow'     => 'Culinary · Nightlife · Lounge',
            'title'       => 'F&B, Nightlife & Hospitality',
            'description' => 'High-energy entertainment destinations, flagship restaurant chains, and bespoke private dining rooms engineered for acoustic and atmospheric impact.',
            'projects'    => array(
                array(
                    'slug'        => 'genki-sushi',
                    'title'       => 'Genki Sushi Flagship',
                    'category'    => 'F&B Brand Space Design (SID)',
                    'description' => 'Curved luminous light-ribbon canopy, fluted architectural wall paneling, custom brand iconography, and streamlined modern dining booths.',
                    'count'       => 6,
                ),
                array(
                    'slug'        => 'imperial-dining',
                    'title'       => 'Imperial Hotpot & VIP Dining Suite',
                    'category'    => 'F&B Space Design (SID)',
                    'description' => 'Bespoke diamond-inlay wall paneling, monochrome checkered stone flooring, emerald velvet seating, and recessed gilt ceiling coffers.',
                    'count'       => 9,
                ),
                array(
                    'slug'        => 'four-fingers',
                    'title'       => '4Fingers Crispy Chicken Concept',
                    'category'    => 'F&B Space Design (SID-02)',
                    'description' => 'Industrial terracotta brick portals, custom neon brand signage, chevron-lit ordering counters, and high-traffic urban dining zoning.',
                    'count'       => 9,
                ),
                array(
                    'slug'        => 'vstage-lounge',
                    'title'       => 'V Stage Lounge',
                    'category'    => 'Nightlife · Entertainment · F&B',
                    'description' => 'Parametric acoustic ceiling soffits, central circular stage architecture, and multi-tier VIP booth zoning with programmable DMX lighting.',
                    'count'       => 10,
                ),
                array(
                    'slug'        => 'vsing-bar',
                    'title'       => 'V Sing Bar & Reception',
                    'category'    => 'Hospitality · Bar & Lounge',
                    'description' => 'Fluted timber counter with ambient crimson kick-lighting, illuminated spirits display cabinetry, and geometric stone flooring.',
                    'count'       => 10,
                ),
                array(
                    'slug'        => 'artisanal-cafe',
                    'title'       => 'Modern Artisanal Cafe',
                    'category'    => 'F&B · Japanese Concept',
                    'description' => 'Chevron wood slat wainscoting, industrial suspended ceiling grid, micro-cement walls, and custom illuminated neon culinary icons.',
                    'count'       => 9,
                ),
                array(
                    'slug'        => 'rose-velvet-lounge',
                    'title'       => 'The Rose Velvet Lounge',
                    'category'    => 'VIP Lounge · Private Club',
                    'description' => 'Tufted leather tub chairs, custom floral gobo lighting projections, acoustic drapery, and warm intimate hospitality lighting.',
                    'count'       => 10,
                ),
            ),
        ),
        array(
            'id'          => 'beauty-cosmetics',
            'number'      => '02',
            'eyebrow'     => 'Skincare · Apothecary · Haute Parfumerie',
            'title'       => 'Beauty, Cosmetics & Fragrance',
            'description' => 'Sensory retail environments and flagship beauty counters crafted with museum-grade illumination, custom brass joinery, and tactile material palettes.',
            'projects'    => array(
                array(
                    'slug'        => 'cle-de-peau',
                    'title'       => 'Clé de Peau Beauté Flagship',
                    'category'    => 'Beauty Brand Spatial Design (SID)',
                    'description' => 'Champagne-gold fluted consultation pods, backlit radiance display niches, and private VIP facial consultation suites.',
                    'count'       => 6,
                ),
                array(
                    'slug'        => 'aesop-atelier',
                    'title'       => 'Aesop Botanical Atelier',
                    'category'    => 'Cosmetic Brand Space Design (SID)',
                    'description' => 'Sculptural floor-to-ceiling bent bamboo rib vaulting, integrated apothecary shelving, and warm organic timber joinery.',
                    'count'       => 10,
                ),
                array(
                    'slug'        => 'armani-beauty',
                    'title'       => 'Giorgio Armani Beauty Boutique',
                    'category'    => 'Luxury Cosmetics · Retail',
                    'description' => 'High-gloss lacquer curved consultation islands, signature crimson architectural paneling, and precision color-rendering illumination.',
                    'count'       => 7,
                ),
                array(
                    'slug'        => 'acqua-di-parma',
                    'title'       => 'Acqua di Parma Parfumerie',
                    'category'    => 'Haute Fragrance · Flagship',
                    'description' => 'Sunlit Italian travertine textures, arched recessed fragrance niches, bespoke timber discovery tables, and warm Mediterranean tones.',
                    'count'       => 11,
                ),
                array(
                    'slug'        => 'artisan-salon',
                    'title'       => 'Bespoke Hair & Beauty Salon',
                    'category'    => ' Grooming · Wellness Studio',
                    'description' => 'Full-height LED-framed styling mirrors, vintage cognac leather hydraulic chairs, and custom mosaic tile zoning.',
                    'count'       => 7,
                ),
            ),
        ),
        array(
            'id'          => 'fashion-luxury-retail',
            'number'      => '03',
            'eyebrow'     => 'Apparel · Fine Jewelry · Wellness Retail',
            'title'       => 'Fashion, Luxury Retail & Wellness',
            'description' => 'Flagship commercial spaces designed to elevate brand equity, guide customer circulation, and maximize merchandising impact.',
            'projects'    => array(
                array(
                    'slug'        => 'haute-menswear',
                    'title'       => 'Haute Menswear Flagship Boutique',
                    'category'    => 'Fashion Brand Spatial Design (SID)',
                    'description' => 'Dramatic crimson stretched-barrisol ceiling light boxes, suspended black steel garment rigging, and minimalist glass accessory vitrines.',
                    'count'       => 13,
                ),
                array(
                    'slug'        => 'amlife-wellness',
                    'title'       => 'AmLife Wellness & Sleep Showroom',
                    'category'    => 'Retail Brand Space Design (SID)',
                    'description' => 'Warm slatted timber portal, sculptural paper-lantern pendant clusters, mirrored central display podiums, and serene therapy trial zones.',
                    'count'       => 6,
                ),
                array(
                    'slug'        => 'laura-fashion',
                    'title'       => 'L\'Aura & BO Apparel Flagship',
                    'category'    => 'Retail · Multi-Brand Boutique',
                    'description' => 'High-visibility mall frontage, mosaic threshold tiling, modular merchandising systems, and high-CRI track illumination.',
                    'count'       => 12,
                ),
                array(
                    'slug'        => 'aethel-jewelry',
                    'title'       => 'Aethel Fine Jewelry Atelier',
                    'category'    => 'Luxury Retail · Haute Joaillerie',
                    'description' => 'Curved museum-grade glass showcases, relief-carved champagne bronze bases, oval cove ceiling lighting, and private viewing salons.',
                    'count'       => 12,
                ),
            ),
        ),
        array(
            'id'          => 'showroom-residential',
            'number'      => '04',
            'eyebrow'     => 'Corporate Experience · Private Estates',
            'title'       => 'Corporate Showrooms & Luxury Residential',
            'description' => 'Immersive brand exhibition centers, turnkey showhouse estates, and bespoke architectural residences.',
            'projects'    => array(
                array(
                    'slug'        => 'corporate-showroom',
                    'title'       => 'Global Sports & FinTech Exhibition Showroom',
                    'category'    => 'Showroom Spatial Design (SID)',
                    'description' => 'Futuristic curved glass and cobalt LED exhibition ribbon, interactive digital trophy pedestals, and biophilic executive lounge zones.',
                    'count'       => 12,
                ),
                array(
                    'slug'        => 'pavilion-showhouse',
                    'title'       => 'Pavilion Showhouse Estate',
                    'category'    => 'Residential · Interior Architecture',
                    'description' => 'Book-matched walnut feature walls, recessed indirect cove illumination, bespoke cantilevered cabinetry, and serene master suites.',
                    'count'       => 10,
                ),
                array(
                    'slug'        => 'seaside-villa',
                    'title'       => 'Modern Seaside Villa',
                    'category'    => 'Residential · Architecture & Build',
                    'description' => 'Sculptural cantilevered facade volumes, integrated linear exterior illumination, custom security gates, and oceanfront terrace.',
                    'count'       => 1,
                ),
            ),
        ),
    );
}
