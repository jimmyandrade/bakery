<?php

namespace Shortcake_Bakery\Shortcodes;

class Phone extends Shortcode {

	public static function get_shortcode_ui_args() {

		$example_text = esc_html_x( 'Example: %s', 'Generic Attribute Description', 'shortcake-bakery' );
		$default_text = esc_html_x( 'Phone:', 'Phone Shortcode Default Title', 'shortcake-bakery' );
		$default_tooltip = esc_html_x( 'Call us today!', 'Phone Shortcode Default Tooltip', 'shortcake-bakery' );

		return array(
			'label' => esc_html_x( 'Phone', 'Shortcode UI Label', 'shortcake-bakery' ),
			'listItemImage' => 'dashicons-phone',
			'attrs' => array(
				array(
					'attr' => 'type',
					'label' => esc_html_x( 'Phone Type', 'Attribute', 'shortcake-bakery' ),
					'type' => 'radio',
					'options' => array(
						'phone' => esc_html_x( 'Phone', 'Phone Type Option', 'shortcake-bakery' ),
						'fax' 	=> esc_html_x( 'Fax', 'Phone Type Option', 'shortcake-bakery' ),
					),
				),
				array(
					'attr'  => 'number',
					'label' => esc_html_x( 'Phone Number', 'Attribute', 'shortcake-bakery' ),
					'description' => esc_html_x( 'Example: 555-555-5555', 'Phone Number Description', 'shortcake-bakery' ),
					'type'  => 'text',
				),
				array(
					'attr' => 'text',
					'label' => esc_html_x( 'Text before number', 'shortcode-ui-essentials' ),
					'description' => sprintf( $example_text, $default_text ),
					'type' => 'text',
				),
				array(
					'attr' => 'tooltip',
					'label' => esc_html_x( 'Link Tooltip', 'Attribute', 'shortcake-bakery' ),
					'description' => sprintf( $example_text, $default_tooltip ),
					'type' => 'text',
				),
			),
		);
	}

	public static function callback( $attrs, $content = '' ) {
		$number  = isset( $attrs['number'] ) && ! empty( $attrs['number'] ) ? $attrs['number'] : '';
		if ( ! $number ) {
			return;
		}

		$type    = isset( $attrs['type'] ) && ! empty( $attrs['type'] ) && 'fax' === $attrs['type'] ? 'fax' : 'phone';
		$icon    = 'fax' === $type ? 'fa-print' : 'fa-mobile-phone';

		$text    = isset( $attrs['text'] ) && ! empty( $attrs['text'] ) ? $attrs['text'] : '';
		$tooltip = isset( $attrs['tooltip'] ) && ! empty( $attrs['tooltip'] ) ? $attrs['tooltip'] : '';
?>
<div class="<?php echo esc_attr( $type ); ?>-area">
    <i class="fa <?php echo esc_attr( $icon ); ?>"></i>
    <?php
	echo esc_html( empty( $text ) ? '' : esc_html( $text ) . ' ' );
	if ( 'phone' === $type ) {
?>
<?php if ( wp_is_mobile() ) { ?><a href="tel:<?php echo esc_attr( $number ); ?>" title="<?php echo esc_attr( $tooltip ); ?>" data-placement="bottom"><?php } ?>
	<?php echo esc_html( $number ); ?>
<?php if ( wp_is_mobile() ) { ?></a><?php } ?>
<?php
	} else {
		echo esc_html( $number ) . "\n";
	}
?>
</div>
<?php
		return ob_get_clean();
	}

}
