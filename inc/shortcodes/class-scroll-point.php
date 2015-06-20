<?php

namespace Shortcake_Bakery\Shortcodes;

class Scroll_Point extends Shortcode {

	public static function get_shortcode_ui_args() {
		return array(
			'label' 		=> _x( 'Scroll Point', 'Shortcode UI Label', 'shortcake-bakery' ),
			'listItemImage' => 'dashicons-arrow-down',
			'attrs' 		=> array(
				array(
					'label' 	=> _x( 'CSS Class', 'Attribute', 'shortcake-bakery' ),
					'attr' 		=> 'class',
					'type' 		=> 'text',
				),
			)
		);
	}

	public static function callback( $attrs, $content = '' ) {

		global $scroll_point_counter;

		if ( isset( $scroll_point_counter ) && intval( $scroll_point_counter ) ) {
			$scroll_point_counter = $scroll_point_counter + 1;
		}
		else {
			$scroll_point_counter = 1;
		}

		$class 	= empty( $attrs['class'] ) ? 'scroll-to-wrap' : 'scroll-to-wrap ' . $attrs['class'];
		$id 	= 'scroll-point-' . $scroll_point_counter;

		ob_start();
?>
<div class="<?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $scroll_point_counter ); ?>">
	<span class="theme-arrow"></span>
</div>
<?php
		return ob_get_clean();
	}

}
