<?php

namespace Shortcake_Bakery\Shortcodes;

class Contact_Field extends Shortcode {

	public static function get_shortcode_ui_args() {

		return array(
			'label' 		=> esc_html_x( 'Contact Field', 'Shortcode UI Label', 'shortcake-bakery' ),
			'listItemImage' => 'dashicons-forms',
			'attrs' 		=> array(
				array(
					'attr' 			=> 'label',
					'label' 		=> esc_html_x( 'Field Label', 'Attribute', 'shortcake-bakery' ),
					'type' 			=> 'text',
				),
				array(
					'attr' 			=> 'type',
					'label' 		=> _x( 'Field Type', 'Attribute', 'shortcake-bakery' ),
					'description' 	=> __( 'Accepted types: name, email, text, radio & select.', 'shortcake-bakery' ),
					'type'  		=> 'select',
					'options' 		=> array(
						'name' 		=> _x( 'Name input', 'Field Type Option', 'shortcake-bakery' ),
						'email' 	=> _x( 'Email input', 'Field Type Option', 'shortcake-bakery' ),
						'text' 		=> _x( 'Text input', 'Field Type Option', 'shortcake-bakery' ),
						'radio' 	=> _x( 'Radio options', 'Field Type Option', 'shortcake-bakery' ),
						'select' 	=> _x( 'Select box', 'Field Type Option', 'shortcake-bakery' ),
					),
				),
				array(
					'attr' 			=> 'required',
					'label' 		=> _x( 'Required', 'Attribute', 'shortcake-bakery' ),
					'type' 			=> 'select',
					'options' 		=> array(
						'' 			=> __( 'No', 'shortcake-bakery' ),
						'1' 		=> __( 'Yes', 'shortcake-bakery' ),
					),
				),
			),
		);

	} // end function __construct

	public static function callback( $attrs, $content = '' ) {
		return \Grunion_Contact_Form::parse_contact_field( $attrs, $content );
	}

} // end class Contact_Field
