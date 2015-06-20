<?php

namespace Shortcake_Bakery\Shortcodes;

class Bucket extends Shortcode {

	public static function get_shortcode_ui_args() {

		/** This filter is documented in wp-admin/includes/media.php */
		$sizes = apply_filters( 'image_size_names_choose', array(
			'thumbnail' => esc_html_x( 'Thumbnail', 'Attribute', 'shortcake-bakery' ),
			'medium'    => esc_html_x( 'Medium', 'Attribute', 'shortcake-bakery' ),
			'large'     => esc_html_x( 'Large', 'Attribute', 'shortcake-bakery' ),
			'full'      => esc_html_x( 'Full Size', 'Attribute', 'shortcake-bakery' ),
		) );

		return array(
			'label' 		=> esc_html_x( 'Bucket', 'Shortcode UI Label', 'shortcake-bakery' ),
			'listItemImage' => 'dashicons-align-left',
			'inner_content' => array(
				'label' 	=> esc_html_x( 'Title', 'Attribute', 'shortcake-bakery' ),
			),
			'attrs' 		=> array(
				array(
					'attr' 			=> 'href',
					'label' 		=> esc_html_x( 'Link URL', 'Attribute', 'shortcake-bakery' ),
					'type' 			=> 'url',
					'meta' 			=> array(
						'placeholder' => '//',
					),
				),
				array(
					'attr' 			=> 'img_id',
					'label' 		=> esc_html_x( 'Featured Image', 'Attribute', 'shortcake-bakery' ),
					'type' 			=> 'attachment',
					'description' 	=> esc_html_x( 'Use an image from your own site.', 'Attribute Description', 'shortcake-bakery' ),
					'libraryType' 	=> array( 'image' ),
					'addButton' 	=> esc_html_x( 'Select Image', 'Add Button', 'shortcake-bakery' ),
					'frameTitle' 	=> esc_html_x( 'Select Image', 'Frame Title', 'shortcake-bakery' ),
				),
				array(
					'attr' 			=> 'img_size',
					'label' 		=> esc_html_x( 'Image Size', 'Attribute', 'shortcake-bakery' ),
					'type' 			=> 'select',
					'options' 		=> $sizes,
				),
				array(
					'attr' 			=> 'img_src',
					'label' 		=> esc_html_x( 'External Image URL', 'Attribute', 'shortcake-bakery' ),
					'type' 			=> 'url',
					'description' 	=> esc_html_x( 'Use this field only if you want to use an external source image.', 'Attribute Description', 'shortcake-bakery' ),
					'meta' 			=> array(
						'placeholder' => '//',
					),
				),
				array(
					'attr' 			=> 'img_width',
					'label' 		=> esc_html_x( 'Image Width', 'Attribute', 'shortcake-bakery' ),
					'type' 			=> 'number',
					'meta' 			=> array(
						'min' 	=> 1,
						'step' 	=> 1,
					),
				),
				array(
					'attr' 			=> 'img_height',
					'label' 		=> esc_html_x( 'Image Height', 'Attribute', 'shortcake-bakery' ),
					'type' 			=> 'number',
					'meta' 			=> array(
						'min' 		=> 1,
						'step' 		=> 1,
					),
				),
				array(
					'attr' 			=> 'class',
					'label' 		=> esc_html_x( 'CSS Class', 'Attribute', 'shortcake-bakery' ),
					'type' 			=> 'text',
				),
				array(
					'attr' 			=> 'id',
					'label' 		=> esc_html_x( 'Numeric ID', 'Attribute', 'shortcake-bakery' ),
					'type' 			=> 'number',
					'meta' 			=> array(
						'min' 	=> 1,
						'step' 	=> 1,
					),
				),

			),
		);
	}

	public static function callback( $attrs, $content = '' ) {

		$shortcode_tag = self::get_shortcode_tag();

		$default_width = apply_filters( $shortcode_tag . '-default-width', 44 );
		$default_height = apply_filters( $shortcode_tag . '-default-height', 44 );

		$img_id 	= empty( $attrs['img_id'] ) ? 0 : $attrs['img_id'];
		$img_src 	= empty( $attrs['img_src'] ) ? '' : $attrs['img_src'];

		$use_local_img = isset( $img_id ) && ! empty( $img_id ) && intval( $img_id ) > 0;
		$use_external_img = isset( $img_src ) && ! empty( $img_src ) && is_null( $img_id );

		$id 		= empty( $attrs['id'] ) ? 0 : $attrs['id'];
		$class 		= empty( $attrs['class'] ) ? '' : $attrs['class'];
		$href 		= empty( $attrs['href'] ) ? '#' : $attrs['href'];
		$img_size 	= empty( $attrs['img_size'] ) ? 'full' : $attrs['img_size'];
		$img_width 	= empty( $attrs['img_width'] ) ? $default_width : $attrs['img_width'];
		$img_height = empty( $attrs['img_height'] ) ? $default_height : $attrs['img_height'];

		$image_args = array(
	    	'alt' 	=> $content,
	    	'class' => 'bucket-img bucket-img-' . intval( $id ) . ' wp-post-image',
	    );

		if ( isset( $img_height ) && ! empty( $img_height ) && intval( $img_height ) > 0 ) {
			$image_args['height'] = intval( $img_height );
		}

		if ( $use_external_img ) {
	    	$image_args['src'] 	  = $img_src;
		}

		if ( isset( $img_width ) && ! empty( $img_width ) && intval( $img_width ) > 0 ) {
			$image_args['width']  = intval( $img_width );
		}

		ob_start();

?>
<div id="bucket<?php echo intval( $id ); ?>" class="bucket <?php echo esc_attr( $class ); ?>">
    <a
    	class="clickable"
    	href="<?php echo esc_attr( $href ); ?>"
    	title="<?php echo esc_attr( $content ); ?>">
    </a>
    <div class="featured-arrow"></div>
	<div class="featured-title-area">
      <h2><?php echo esc_html( $content ); ?></h2>
    </div>
    <div class="featured-image-area">
    	<?php
		if ( $use_local_img ) {
			echo wp_get_attachment_image( intval( $img_id ), $img_size, false, $image_args );
		}
		else {
?>
<img <?php foreach ( $image_args as $key => $value ) { echo esc_attr( $key ) . '="' . esc_attr( $value ) . '" '; } ?> />
<?php
		}
		?>
    </div>
</div>
<?php
		return ob_get_clean();

	}

}
