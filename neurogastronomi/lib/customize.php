<?php

/**
 * Customizer additions.
 *
 * @package Neurogastronomi
 * @author  mono voce aps
 * @link    https://github.com/mbernth/Genesis-Neurogastronomi-theme
 * @license GPL2-0+
 */

/**
 * Get default accent color for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for accent color.
 */
 
function neurogastronomi_customizer_get_default_accent_color() {
	return '#e85555';
}

add_action( 'customize_register', 'neurogastronomi_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function neurogastronomi_customizer_register() {

	global $wp_customize;

	$wp_customize->add_section( 'neurogastronomi-image', array(
		'title'          => __( 'Front Page Image', 'neurogastronomi' ),
		'description'    => __( '<p>Use the default image or personalize your site by uploading your own image for the front page 1 widget background.</p><p>The default image is <strong>1600 x 1050 pixels</strong>.</p>', 'neurogastronomi' ),
		'priority'       => 75,
	) );

	$wp_customize->add_setting( 'neurogastronomi-front-image', array(
		'default'  => sprintf( '%s/images/front-page-1.jpg', get_stylesheet_directory_uri() ),
		'sanitize_callback' => 'esc_url_raw',
		'type'     => 'option',
	) );
	 
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'front-background-image',
			array(
				'label'       => __( 'Front Image Upload', 'neurogastronomi' ),
				'section'     => 'neurogastronomi-image',
				'settings'    => 'neurogastronomi-front-image',
			)
		)
	);

	$wp_customize->add_setting(
		'neurogastronomi_accent_color',
		array(
			'default'           => neurogastronomi_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'neurogastronomi_accent_color',
			array(
				'description' => __( 'Change the default color for button hover and the footer widget background.', 'neurogastronomi' ),
			    'label'       => __( 'Accent Color', 'neurogastronomi' ),
			    'section'     => 'colors',
			    'settings'    => 'neurogastronomi_accent_color',
			)
		)
	);

    //* Add front page setting to the Customizer
    $wp_customize->add_section( 'neurogastronomi_journal_section', array(
        'title'    => __( 'Front Page Content Settings', 'neurogastronomi' ),
        'description' => __( 'Choose if you would like to display the content section below widget sections on the front page.', 'neurogastronomi' ),
        'priority' => 75.01,
    ));

    //* Add front page setting to the Customizer
    $wp_customize->add_setting( 'neurogastronomi_journal_setting', array(
        'default'           => 'true',
        'capability'        => 'edit_theme_options',
        'type'              => 'option',
    ));

    $wp_customize->add_control( new WP_Customize_Control( 
        $wp_customize, 'neurogastronomi_journal_control', array(
			'label'       => __( 'Front Page Content Section Display', 'neurogastronomi' ),
			'description' => __( 'Show or Hide the content section. The section will display on the front page by default.', 'neurogastronomi' ),
			'section'     => 'neurogastronomi_journal_section',
			'settings'    => 'neurogastronomi_journal_setting',
			'type'        => 'select',
			'choices'     => array(                    
				'false'   => __( 'Hide content section', 'neurogastronomi' ),
				'true'    => __( 'Show content section', 'neurogastronomi' ),
			),
        ))
	);
	
    $wp_customize->add_setting( 'neurogastronomi_journal_text', array(
		'default'           => __( 'Our Journal', 'neurogastronomi' ),
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'wp_kses_post',
		'type'              => 'option',
    ));

    $wp_customize->add_control( new WP_Customize_Control( 
        $wp_customize, 'neurogastronomi_journal_text_control', array(
			'label'      => __( 'Journal Section Heading Text', 'neurogastronomi' ),
			'description' => __( 'Choose the heading text you would like to display above posts on the front page.<br /><br />This text will show when displaying posts and using widgets on the front page.', 'neurogastronomi' ),
			'section'    => 'neurogastronomi_journal_section',
			'settings'   => 'neurogastronomi_journal_text',
			'type'       => 'text',
		))
	);

}
