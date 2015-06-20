<?php

namespace Shortcake_Bakery\Shortcodes;

class Heading extends Shortcode {

	const MIN_HEADING_LEVEL 	= 1;
	const MAX_HEADING_LEVEL 	= 6;
	const DEFAULT_HEADING_LEVEL = 2;

	public static function get_shortcode_ui_args() {

		$description = _x( 'Heading level (from %1$s to %2$s). Default is %3$s.', '%1$s = min heading level number, %2$s = max heading level number, %3$s = default heading level number', 'shortcake-bakery' );

		return array(
			'label' 		=> _x( 'Heading', 'Shortcode UI Label', 'shortcake-bakery' ),
			'listItemImage' => 'dashicons-editor-textcolor',
			'inner_content' => array(
				'label' 	=> _x( 'Title', 'Attribute', 'shortcake-bakery' ),
			),
			'attrs' 		=> array(
				array(
					'label' 		=> _x( 'Heading Level', 'Attribute', 'shortcake-bakery' ),
					'description' 	=> sprintf( $description, Heading::MIN_HEADING_LEVEL, Heading::MAX_HEADING_LEVEL, Heading::DEFAULT_HEADING_LEVEL ),
					'attr' 			=> 'level',
					'type' 			=> 'number',
					'meta' 			=> array(
						'max' 		=> Heading::MAX_HEADING_LEVEL,
						'min' 		=> Heading::MIN_HEADING_LEVEL,
						'step' 		=> 1,
					),
				),
			),
		);
	}

	public static function callback( $attrs, $content = '' ) {
		$level = empty( $attrs['level'] ) ? Heading::DEFAULT_HEADING_LEVEL : intval( $attrs['level'] );
		$slug = sanitize_title( $content );
		ob_start();
?>
<h<?php echo intval( $level ); ?> id="<?php echo esc_attr( $slug ); ?>">
	<a class="scroll-to-wrap" href="#<?php echo esc_attr( $slug ); ?>" title="<?php echo esc_attr( $content ); ?>">
		<?php echo esc_html( $content ); ?>
	</a>
</h<?php echo intval( $level ); ?>>
<?php
		return ob_get_clean();
	}

}
