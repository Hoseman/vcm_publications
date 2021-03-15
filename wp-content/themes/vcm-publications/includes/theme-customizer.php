<?php
function ah_customize_register( $wp_customize ){

    $wp_customize->add_setting( 'ah_telephone_handle', [
        'default'  =>  ''
    ]);

    $wp_customize->add_setting( 'ah_email_handle', [
        'default'  =>  ''
    ]);

    $wp_customize->add_setting( 'ah_address_1_handle', [
        'default'  =>  ''
    ]);

    $wp_customize->add_setting( 'ah_address_2_handle', [
        'default'  =>  ''
    ]);

    $wp_customize->add_setting( 'ah_address_3_handle', [
        'default'  =>  ''
    ]);

    $wp_customize->add_setting( 'ah_address_4_handle', [
        'default'  =>  ''
    ]);

    $wp_customize->add_setting( 'ah_address_5_handle', [
        'default'  =>  ''
    ]);

    $wp_customize->add_setting( 'ah_heading_1_handle', [
        'default'  =>  ''
    ]);

    $wp_customize->add_setting( 'ah_subheading_1_handle', [
        'default'  =>  ''
    ]);

    $wp_customize->add_setting( 'ah_heading_2_handle', [
        'default'  =>  ''
    ]);

    $wp_customize->add_setting( 'ah_subheading_2_handle', [
        'default'  =>  ''
    ]);

    $wp_customize->add_setting( 'ah_heading_3_handle', [
        'default'  =>  ''
    ]);

    $wp_customize->add_setting( 'ah_subheading_3_handle', [
        'default'  =>  ''
    ]);

    $wp_customize->add_section( 'ah_tel_email_section', [
        'title' =>  __('VCM Contact Details', 'vcm-publications'),
        'priority'  =>  30
    ]);

    $wp_customize->add_section( 'ah_quality_banner_section', [
        'title' =>  __('VCM Quality Service Banner', 'vcm-publications'),
        'priority'  =>  30
    ]);

    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'ah_quality_banner_heading_1_input',
        array(
            'label' => __('Banner Heading 1', 'vcm-publications'),
            'section' => 'ah_quality_banner_section',
            'settings' => 'ah_heading_1_handle'
        )
    ));

    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'ah_quality_banner_subheading_1_input',
        array(
            'label' => __('Banner Subheading 1', 'vcm-publications'),
            'section' => 'ah_quality_banner_section',
            'settings' => 'ah_subheading_1_handle'
        )
    ));

    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'ah_quality_banner_heading_2_input',
        array(
            'label' => __('Banner Heading 2', 'vcm-publications'),
            'section' => 'ah_quality_banner_section',
            'settings' => 'ah_heading_2_handle'
        )
    ));

    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'ah_quality_banner_subheading_2_input',
        array(
            'label' => __('Banner Subheading 2', 'vcm-publications'),
            'section' => 'ah_quality_banner_section',
            'settings' => 'ah_subheading_2_handle'
        )
    ));

    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'ah_quality_banner_heading_3_input',
        array(
            'label' => __('Banner Heading 3', 'vcm-publications'),
            'section' => 'ah_quality_banner_section',
            'settings' => 'ah_heading_3_handle'
        )
    ));

    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'ah_quality_banner_subheading_3_input',
        array(
            'label' => __('Banner Subheading 3', 'vcm-publications'),
            'section' => 'ah_quality_banner_section',
            'settings' => 'ah_subheading_3_handle'
        )
    ));

    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'ah_tel_email_telephone_input',
        array(
            'label' => __('Telephone', 'vcm-publications'),
            'section' => 'ah_tel_email_section',
            'settings' => 'ah_telephone_handle'
        )
    ));

    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'ah_tel_email_email_input',
        array(
            'label' => __('Email', 'vcm-publications'),
            'section' => 'ah_tel_email_section',
            'settings' => 'ah_email_handle'
        )
    ));

    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'ah_address_1_input',
        array(
            'label' => __('Company Name', 'vcm-publications'),
            'section' => 'ah_tel_email_section',
            'settings' => 'ah_address_1_handle'
        )
    ));

    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'ah_address_2_input',
        array(
            'label' => __('Address Line 2', 'vcm-publications'),
            'section' => 'ah_tel_email_section',
            'settings' => 'ah_address_2_handle'
        )
    ));

    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'ah_address_3_input',
        array(
            'label' => __('Address Line 3', 'vcm-publications'),
            'section' => 'ah_tel_email_section',
            'settings' => 'ah_address_3_handle'
        )
    ));

    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'ah_address_4_input',
        array(
            'label' => __('Address Line 4', 'vcm-publications'),
            'section' => 'ah_tel_email_section',
            'settings' => 'ah_address_4_handle'
        )
    ));

    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'ah_address_5_input',
        array(
            'label' => __('Postcode', 'vcm-publications'),
            'section' => 'ah_tel_email_section',
            'settings' => 'ah_address_5_handle'
        )
    ));

}