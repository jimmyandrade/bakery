<?php

namespace Shortcake_Bakery\Shortcodes;

class Google_Map extends Shortcode {

	const MIN_ZOOM_LEVEL = 0;
	const MAX_ZOOM_LEVEL = 21;
	const DEFAULT_ZOOM_LEVEL = 15;

	public static function get_shortcode_ui_args() {

		$description = _x( 'Zoom level (from %1$s to %2$s). Default is %3$s.', '%1$s = min zoom level number, %2$s = max zoom level number, %3$s = default zoom level number', 'shortcake-bakery' );

		return array(
			'label' 		=> esc_html_x( 'Google Map', 'Shortcode UI Label', 'shortcake-bakery' ),
			'listItemImage' => 'dashicons-location-alt',
			'attrs' 		=> array(
				array(
					'attr' 			=> 'q',
					'label' 		=> esc_html_x( 'Map Query Address', 'Attribute', 'shortcake-bakery' ),
					'type' 			=> 'textarea',
					'description' 	=> esc_html_x( 'Example: 3785 Brickway Blvd., Santa Rosa, CA 95403', 'Map Query Address - Attribute Description', 'shortcake-bakery' ),
				),
				array(
					'attr' 			=> 'z',
					'label' 		=> esc_html_x( 'Zoom', 'Attribute', 'shortcake-bakery' ),
					'description' 	=> sprintf( $description, Google_Map::MIN_ZOOM_LEVEL, Google_Map::MAX_ZOOM_LEVEL, Google_Map::DEFAULT_ZOOM_LEVEL ),
					'type' 			=> 'number',
					'meta' 			=> array(
						'max' 		=> Google_Map::MAX_ZOOM_LEVEL,
						'min' 		=> Google_Map::MIN_ZOOM_LEVEL,
						'step' 		=> 1,
					),
				),
				array(
					'attr' 			=> 'href',
					'label' 		=> esc_html_x( 'Link', 'Attribute', 'shortcake-bakery' ),
					'type' 			=> 'url',
					'meta' 			=> array(
						'placeholder' => '//',
					),
				),
			),
		);
	}

	private static function urlencode_address( $address ) {
		$address = strtolower( $address );
		$address = preg_replace( '/\s+/', ' ', trim( $address ) ); // Get rid of any unwanted whitespace
		$address = str_ireplace( ' ', '+', $address ); // Use + not %20
		return urlencode( $address );
	}

	/**
	 * Build the map link
	 *
	 * Google map urls have lots of available params but zoom (z) and query (q) are enough.
	 *
	 * @param string $address Required. The map address.
	 * @param int $zoom Optional. Map zoom. Default is const DEFAULT_ZOOM_LEVEL.
	 */
	private static function build_map_link( $address, $zoom = Google_Map::DEFAULT_ZOOM_LEVEL ) {

		$query_uri = 'http://maps.google.com/maps';
		$params = array(
			'q' => static::urlencode_address( $address ),
			'output' => 'embed',
			'z' => $zoom,
		);

		return esc_url( add_query_arg( $params, $query_uri ) );

	}

	public static function callback( $attrs, $content = '' ) {
		$href 	= empty( $attrs['href'] ) ? '#' : $attrs['href'];
		$q 		= empty( $attrs['q'] ) ? '' : $attrs['q'];
		$z 		= empty( $attrs['z'] ) ? Google_Map::DEFAULT_ZOOM_LEVEL : intval( $attrs['z'] );
		$src 	= static::build_map_link( $q, $z );
		ob_start();
?>
<a data-toggle="modal" href="<?php echo esc_attr( $href ); ?>" role="button">
	<div id="mapContainer">
    	<iframe src="<?php echo esc_url( $src ); ?>">
    		<?php echo esc_html( $q ); ?>
    	</iframe>
    </div>
</a>
<?php
		return ob_get_clean();
	} // end function callback

} // end class Google_Map
