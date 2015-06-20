<?php

namespace Shortcake_Bakery\Shortcodes;

class Mailing_Address extends Shortcode {

	public static function get_shortcode_ui_args() {
		return array(
			'label' => esc_html_x( 'Mailing Address', 'Shortcode UI Label', 'shortcake-bakery' ),
			'listItemImage' => 'dashicons-location',
			'inner_content' => array(
				'label' => esc_html_x( 'Person or Business Name', 'Attribute', 'shortcake-bakery' ),
			),
			'attrs' => array(
				array(
					'attr' 	=> 'title',
					'label' => esc_html_x( 'Title', 'Shortcode UI Label', 'shortcake-bakery' ),
					'type' 	=> 'text',
				),
				array(
					'attr' 	=> 'street_address',
					'label' => esc_html_x( 'Street Address', 'Attribute', 'shortcake-bakery' ),
					'description' => esc_html_x( 'Example: 3785 Brickway Blvd.', 'Street Address Example', 'shortcake-bakery' ),
					'type' => 'text',
				),
				array(
					'attr' 	=> 'locality',
					'label' => esc_html_x( 'Locality', 'Attribute', 'shortcake-bakery' ),
					'description' => esc_html_x( 'Example: Santa Rosa', 'Locality Example', 'shortcake-bakery' ),
					'type' => 'text',
				),
				array(
					'attr' 	=> 'region',
					'label' => esc_html_x( 'Region', 'Attribute', 'shortcake-bakery' ),
					'description' => esc_html_x( 'Example: CA', 'Region Example', 'shortcake-bakery' ),
					'type' => 'text',
				),
				array(
					'attr' 	=> 'postal_code',
					'label' => esc_html_x( 'Postal Code', 'Attribute', 'shortcake-bakery' ),
					'description' => esc_html_x( 'Example: 95403', 'Postal Code Example', 'shortcake-bakery' ),
				),
			),
		);
	}

	public static function callback( $attrs, $content = '' ) {

		$title 			= empty( $attrs['title'] ) ? '' : $attrs['title'];
		$street_address = empty( $attrs['street_address'] ) ? '' : $attrs['street_address'];
		$locality 		= empty( $attrs['locality'] ) ? '' : $attrs['locality'];
		$region 		= empty( $attrs['region'] ) ? '' : $attrs['region'];
		$postal_code 	= empty( $attrs['postal_code'] ) ? '' : $attrs['postal_code'];
		ob_start();
?>
<div class="mailing-address">
    <i class="fa fa-map-marker"></i>
    <?php if ( $title ) { ?>
    <?php echo esc_html( $title ); ?><br /><br />
    <span><?php echo esc_html( $content ); ?></span><br />
    <?php } ?>
    <?php if ( $street_address ) { ?>
    <span class="street-address" itemprop="streetAddress">
    	<?php echo esc_html( $street_address ); ?>
    </span><br />
    <?php } ?>
    <?php if ( $locality ) { ?>
    <span class="locality" itemprop="addressLocality">
    	<?php echo esc_html( $locality ); ?>
    </span>,
    <?php } ?>
    <?php if ( $region ) { ?>
    <abbr class="region" itemprop="addressRegion">
    	<?php echo esc_html( $region ); ?>
    </abbr>
    <?php } ?>
    <?php if ( $postal_code ) { ?>
    <span class="postal-code"  itemprop="postalCode">
    	<?php echo esc_html( $postal_code ); ?>
    </span>
    <?php } ?>
</div>
<?php
		return ob_get_clean();
	}

}
