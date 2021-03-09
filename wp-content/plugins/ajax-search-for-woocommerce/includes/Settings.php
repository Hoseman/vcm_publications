<?php

namespace DgoraWcas;

use  DgoraWcas\Admin\Promo\Upgrade ;
use  DgoraWcas\Admin\SettingsAPI ;
use  DgoraWcas\Engines\TNTSearchMySQL\Indexer\Builder ;
use  DgoraWcas\Engines\TNTSearchMySQL\Indexer\Scheduler ;
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Settings API data
 */
class Settings
{
    /**
     * Unique settings slug
     * @var string
     */
    private  $settingSlug = DGWT_WCAS_SETTINGS_KEY ;
    /**
     * All options values in one array
     * @var array
     */
    public  $opt ;
    /**
     * Settings API object
     * @var object
     */
    public  $settingsApi ;
    /**
     * Check if user can see advanced settings
     * @var object
     */
    public  $canSeeAdvSettings = null ;
    /**
     * Settings defaults
     * @var array
     */
    public  $defaults = array() ;
    /**
     * Settings cache
     * @var array
     */
    private  $settingsCache = array() ;
    public function __construct()
    {
        global  $dgwtWcasSettings ;
        // Set global variable with settings
        $settings = get_option( $this->settingSlug );
        
        if ( !isset( $settings ) || empty($settings) ) {
            $dgwtWcasSettings = array();
        } else {
            $dgwtWcasSettings = $settings;
        }
        
        $this->settingsApi = new SettingsAPI( $this->settingSlug );
        add_action( 'admin_init', array( $this, 'settingsInit' ) );
        add_filter(
            'dgwt/wcas/settings/option_value',
            array( $this, 'restoreDefaultValueForFreePlan' ),
            10,
            3
        );
        add_action( 'wp_ajax_dgwt_wcas_adv_settings', array( $this, 'toggleAdvancedSettings' ) );
    }
    
    /**
     * Set sections and fields
     *
     * @return void
     */
    public function settingsInit()
    {
        //Set the settings
        $this->settingsApi->set_sections( $this->settings_sections() );
        $this->settingsApi->set_fields( $this->settingsFields() );
        //Initialize settings
        $this->settingsApi->settings_init();
    }
    
    /*
     * Set settings sections
     *
     * @return array settings sections
     */
    public function settings_sections()
    {
        $sections = array(
            5  => array(
            'id'    => 'dgwt_wcas_basic',
            'title' => __( 'Starting', 'ajax-search-for-woocommerce' ),
        ),
            10 => array(
            'id'    => 'dgwt_wcas_form_body',
            'title' => __( 'Search bar', 'ajax-search-for-woocommerce' ),
        ),
            15 => array(
            'id'    => 'dgwt_wcas_autocomplete',
            'title' => __( 'Autocomplete', 'ajax-search-for-woocommerce' ),
        ),
            25 => array(
            'id'    => 'dgwt_wcas_search',
            'title' => __( 'Search config', 'ajax-search-for-woocommerce' ),
        ),
        );
        
        if ( dgoraAsfwFs()->is_premium() ) {
            $sections[30] = array(
                'id'    => 'dgwt_wcas_performance',
                'title' => __( 'Indexer', 'ajax-search-for-woocommerce' ),
            );
        } else {
            $sections[30] = array(
                'id'    => 'dgwt_wcas_performance',
                'title' => Helpers::getSettingsProLabel( __( 'Increase sales', 'ajax-search-for-woocommerce' ), 'header', __( 'by simple tricks', 'ajax-search-for-woocommerce' ) ),
            );
        }
        
        $sections = apply_filters( 'dgwt_wcas_settings_sections', $sections );
        // deprecated since v1.2.0
        $sections = apply_filters( 'dgwt/wcas/settings/sections', $sections );
        ksort( $sections );
        return $sections;
    }
    
    /**
     * Create settings fields
     *
     * @return array settings fields
     */
    function settingsFields()
    {
        $settingsFields = array(
            'dgwt_wcas_basic'        => apply_filters( 'dgwt/wcas/settings/section=basic', array(
            90  => array(
            'name'  => 'embedding_search_form_head',
            'label' => __( 'How to add search bar in your theme?', 'ajax-search-for-woocommerce' ),
            'type'  => 'head',
            'class' => 'dgwt-wcas-sgs-header',
        ),
            100 => array(
            'name'  => 'how_to_use',
            'label' => __( 'How to add?', 'ajax-search-for-woocommerce' ),
            'type'  => 'desc',
            'class' => 'dgwt-wcas-only-desc',
            'desc'  => Helpers::howToUseHtml(),
        ),
        ) ),
            'dgwt_wcas_form_body'    => apply_filters( 'dgwt/wcas/settings/section=form', array(
            100  => array(
            'name'  => 'form_head',
            'label' => __( 'Basic', 'ajax-search-for-woocommerce' ),
            'type'  => 'head',
            'class' => 'dgwt-wcas-sgs-header',
        ),
            200  => array(
            'name'    => 'min_chars',
            'label'   => __( 'Minimum characters', 'ajax-search-for-woocommerce' ),
            'type'    => 'number',
            'size'    => 'small',
            'class'   => 'js-dgwt-wcas-adv-settings',
            'desc'    => __( 'Min characters to show autocomplete', 'ajax-search-for-woocommerce' ),
            'default' => 3,
        ),
            300  => array(
            'name'    => 'max_form_width',
            'label'   => __( 'Max form width', 'ajax-search-for-woocommerce' ),
            'type'    => 'number',
            'size'    => 'small',
            'desc'    => ' px. ' . __( 'To set 100% width leave blank', 'ajax-search-for-woocommerce' ),
            'class'   => 'js-dgwt-wcas-adv-settings',
            'default' => 600,
        ),
            400  => array(
            'name'    => 'show_submit_button',
            'label'   => __( 'Show submit button', 'ajax-search-for-woocommerce' ),
            'type'    => 'checkbox',
            'class'   => 'dgwt-wcas-options-cb-toggle js-dgwt-wcas-cbtgroup-submit-btn',
            'size'    => 'small',
            'default' => 'off',
        ),
            500  => array(
            'name'    => 'search_submit_text',
            'label'   => __( 'Submit label', 'ajax-search-for-woocommerce' ) . ' ' . Helpers::createQuestionMark( 'search-submit-text', __( 'To display the magnifier icon leave this field empty.', 'ajax-search-for-woocommerce' ) ),
            'type'    => 'text',
            'class'   => 'js-dgwt-wcas-cbtgroup-submit-btn',
            'default' => __( 'Search', 'ajax-search-for-woocommerce' ),
        ),
            600  => array(
            'name'    => 'search_placeholder',
            'label'   => __( 'Search input placeholder', 'ajax-search-for-woocommerce' ),
            'type'    => 'text',
            'default' => __( 'Search for products...', 'ajax-search-for-woocommerce' ),
        ),
            630  => array(
            'name'  => 'layout_head',
            'label' => __( 'Layout (beta)', 'ajax-search-for-woocommerce' ),
            'type'  => 'head',
            'class' => 'dgwt-wcas-sgs-header js-dgwt-wcas-adv-settings',
        ),
            660  => array(
            'name'    => 'search_layout',
            'label'   => __( 'Layout', 'ajax-search-for-woocommerce' ),
            'type'    => 'select',
            'options' => array(
            'classic'       => __( 'Search bar only', 'ajax-search-for-woocommerce' ),
            'icon'          => __( 'Search icon', 'ajax-search-for-woocommerce' ),
            'icon-flexible' => __( 'Icon on mobile, search bar on desktop', 'ajax-search-for-woocommerce' ),
        ),
            'default' => 'classic',
            'class'   => 'js-dgwt-wcas-adv-settings',
        ),
            680  => array(
            'name'    => 'enable_mobile_overlay',
            'label'   => __( 'Overlay on mobile', 'ajax-search-for-woocommerce' ),
            'desc'    => __( 'The search will open in overlay on mobile', 'ajax-search-for-woocommerce' ),
            'type'    => 'checkbox',
            'default' => 'on',
            'class'   => 'js-dgwt-wcas-adv-settings',
        ),
            690  => array(
            'name'    => 'mobile_breakpoint',
            'label'   => __( 'Mobile breakpoint', 'ajax-search-for-woocommerce' ),
            'desc'    => __( 'px', 'ajax-search-for-woocommerce' ),
            'type'    => 'number',
            'class'   => 'js-dgwt-wcas-adv-settings',
            'size'    => 'small',
            'default' => 992,
        ),
            700  => array(
            'name'  => 'search_form',
            'label' => __( 'Colors', 'ajax-search-for-woocommerce' ),
            'type'  => 'head',
            'class' => 'dgwt-wcas-sgs-header js-dgwt-wcas-adv-settings',
        ),
            750  => array(
            'name'    => 'search_icon_color',
            'label'   => __( 'Search icon', 'ajax-search-for-woocommerce' ),
            'type'    => 'color',
            'class'   => 'js-dgwt-wcas-adv-settings',
            'default' => '',
        ),
            800  => array(
            'name'    => 'bg_input_color',
            'label'   => __( 'Search input background', 'ajax-search-for-woocommerce' ),
            'type'    => 'color',
            'class'   => 'js-dgwt-wcas-adv-settings',
            'default' => '',
        ),
            900  => array(
            'name'    => 'text_input_color',
            'label'   => __( 'Search input text', 'ajax-search-for-woocommerce' ),
            'type'    => 'color',
            'class'   => 'js-dgwt-wcas-adv-settings',
            'default' => '',
        ),
            1000 => array(
            'name'    => 'border_input_color',
            'label'   => __( 'Search input border', 'ajax-search-for-woocommerce' ),
            'type'    => 'color',
            'class'   => 'js-dgwt-wcas-adv-settings',
            'default' => '',
        ),
            1100 => array(
            'name'    => 'bg_submit_color',
            'label'   => __( 'Search submit background', 'ajax-search-for-woocommerce' ),
            'type'    => 'color',
            'class'   => 'js-dgwt-wcas-adv-settings js-dgwt-wcas-cbtgroup-submit-btn',
            'default' => '',
        ),
            1200 => array(
            'name'    => 'text_submit_color',
            'label'   => __( 'Search submit text', 'ajax-search-for-woocommerce' ),
            'type'    => 'color',
            'class'   => 'js-dgwt-wcas-adv-settings js-dgwt-wcas-cbtgroup-submit-btn',
            'default' => '',
        ),
            1500 => array(
            'name'  => 'preloader_head',
            'label' => __( 'Preloader', 'ajax-search-for-woocommerce' ),
            'type'  => 'head',
            'class' => 'dgwt-wcas-sgs-header js-dgwt-wcas-adv-settings',
        ),
            1700 => array(
            'name'    => 'show_preloader',
            'label'   => __( 'Show preloader', 'ajax-search-for-woocommerce' ),
            'class'   => 'dgwt-wcas-options-cb-toggle js-dgwt-wcas-cbtgroup-preloader js-dgwt-wcas-adv-settings',
            'type'    => 'checkbox',
            'default' => 'on',
        ),
            1800 => array(
            'name'    => 'preloader_url',
            'label'   => __( 'Upload preloader image', 'ajax-search-for-woocommerce' ),
            'class'   => 'js-dgwt-wcas-cbtgroup-preloader js-dgwt-wcas-adv-settings',
            'type'    => 'file',
            'default' => '',
        ),
        ) ),
            'dgwt_wcas_autocomplete' => apply_filters( 'dgwt/wcas/settings/section=autocomplete', array(
            20   => array(
            'name'  => 'autocomplete_head',
            'label' => __( 'Basic', 'ajax-search-for-woocommerce' ),
            'type'  => 'head',
            'class' => 'dgwt-wcas-sgs-header',
        ),
            50   => array(
            'name'    => 'suggestions_limit',
            'label'   => __( 'Limit', 'ajax-search-for-woocommerce' ),
            'type'    => 'number',
            'size'    => 'small',
            'desc'    => __( 'Maximum number of suggestions', 'ajax-search-for-woocommerce' ),
            'default' => 7,
        ),
            70   => array(
            'name'    => 'show_grouped_results',
            'label'   => __( 'Group results', 'ajax-search-for-woocommerce' ),
            'type'    => 'checkbox',
            'size'    => 'small',
            'default' => 'on',
            'class'   => 'js-dgwt-wcas-adv-settings',
        ),
            80   => array(
            'name'    => 'search_no_results_text',
            'label'   => _x( 'No results label', 'admin', 'ajax-search-for-woocommerce' ),
            'type'    => 'text',
            'default' => __( 'No results', 'ajax-search-for-woocommerce' ),
        ),
            100  => array(
            'name'  => 'product_suggestion_head',
            'label' => __( 'Products', 'ajax-search-for-woocommerce' ),
            'type'  => 'head',
            'class' => 'dgwt-wcas-sgs-header',
        ),
            300  => array(
            'name'    => 'show_product_image',
            'label'   => __( 'Show product image', 'ajax-search-for-woocommerce' ),
            'type'    => 'checkbox',
            'default' => 'on',
        ),
            400  => array(
            'name'    => 'show_product_price',
            'label'   => __( 'Show price', 'ajax-search-for-woocommerce' ),
            'type'    => 'checkbox',
            'default' => 'off',
        ),
            500  => array(
            'name'    => 'show_product_desc',
            'label'   => __( 'Show product description', 'ajax-search-for-woocommerce' ),
            'type'    => 'checkbox',
            'default' => 'off',
            'class'   => 'js-dgwt-wcas-adv-settings',
        ),
            600  => array(
            'name'    => 'show_product_sku',
            'label'   => __( 'Show SKU', 'ajax-search-for-woocommerce' ),
            'type'    => 'checkbox',
            'default' => 'off',
        ),
            900  => array(
            'name'    => 'search_see_all_results_text',
            'label'   => __( 'More results label', 'ajax-search-for-woocommerce' ),
            'type'    => 'text',
            'default' => __( 'See all products...', 'ajax-search-for-woocommerce' ),
        ),
            1000 => array(
            'name'  => 'non_products_in_autocomplete_head',
            'label' => __( 'Non-Products in autocomplete', 'ajax-search-for-woocommerce' ),
            'type'  => 'head',
            'class' => 'dgwt-wcas-sgs-header',
        ),
            1100 => array(
            'name'    => 'show_matching_categories',
            'label'   => __( 'Show categories', 'ajax-search-for-woocommerce' ),
            'type'    => 'checkbox',
            'class'   => 'js-dgwt-wcas-settings-margin',
            'default' => 'on',
        ),
            1300 => array(
            'name'    => 'show_matching_tags',
            'label'   => __( 'Show tags', 'ajax-search-for-woocommerce' ),
            'type'    => 'checkbox',
            'class'   => 'js-dgwt-wcas-settings-margin js-dgwt-wcas-adv-settings',
            'default' => 'off',
        ),
            1600 => array(
            'name'    => 'show_matching_posts',
            'label'   => __( 'Show posts', 'ajax-search-for-woocommerce' ),
            'type'    => 'checkbox',
            'class'   => 'js-dgwt-wcas-adv-settings dgwt-wcas-premium-only',
            'default' => 'off',
        ),
            1800 => array(
            'name'    => 'show_matching_pages',
            'label'   => __( 'Show pages', 'ajax-search-for-woocommerce' ),
            'type'    => 'checkbox',
            'class'   => 'js-dgwt-wcas-adv-settings dgwt-wcas-premium-only',
            'default' => 'off',
        ),
            2000 => array(
            'name'  => 'details_box_head',
            'label' => __( 'Details panel', 'ajax-search-for-woocommerce' ),
            'type'  => 'head',
            'class' => 'dgwt-wcas-sgs-header',
        ),
            2100 => array(
            'name'    => 'show_details_box',
            'label'   => __( 'Show Details panel', 'ajax-search-for-woocommerce' ) . ' ' . Helpers::createQuestionMark( 'details-box', __( 'The Details panel is an additional container for extended information. The details are changed dynamically when a user mouse over one of the suggestions.', 'ajax-search-for-woocommerce' ) ),
            'type'    => 'checkbox',
            'size'    => 'small',
            'default' => 'off',
        ),
            2500 => array(
            'name'  => 'suggestions_style_head',
            'label' => __( 'Suggestions colors', 'ajax-search-for-woocommerce' ),
            'type'  => 'head',
            'class' => 'dgwt-wcas-sgs-header js-dgwt-wcas-adv-settings',
        ),
            2600 => array(
            'name'    => 'sug_bg_color',
            'label'   => __( 'Suggestion background', 'ajax-search-for-woocommerce' ),
            'type'    => 'color',
            'class'   => 'js-dgwt-wcas-adv-settings',
            'default' => '',
        ),
            2700 => array(
            'name'    => 'sug_hover_color',
            'label'   => __( 'Suggestion selected', 'ajax-search-for-woocommerce' ),
            'type'    => 'color',
            'class'   => 'js-dgwt-wcas-adv-settings',
            'default' => '',
        ),
            2800 => array(
            'name'    => 'sug_text_color',
            'label'   => __( 'Text color', 'ajax-search-for-woocommerce' ),
            'type'    => 'color',
            'class'   => 'js-dgwt-wcas-adv-settings',
            'default' => '',
        ),
            2900 => array(
            'name'    => 'sug_highlight_color',
            'label'   => __( 'Highlight color', 'ajax-search-for-woocommerce' ),
            'type'    => 'color',
            'class'   => 'js-dgwt-wcas-adv-settings',
            'default' => '',
        ),
            3000 => array(
            'name'    => 'sug_border_color',
            'label'   => __( 'Border color', 'ajax-search-for-woocommerce' ),
            'type'    => 'color',
            'class'   => 'js-dgwt-wcas-adv-settings',
            'default' => '',
        ),
        ) ),
            'dgwt_wcas_search'       => apply_filters( 'dgwt/wcas/settings/section=search', array(
            10  => array(
            'name'  => 'search_search_head',
            'label' => __( 'Products search scope', 'ajax-search-for-woocommerce' ),
            'type'  => 'head',
            'class' => 'dgwt-wcas-sgs-header',
        ),
            50  => array(
            'name'    => 'search_in_product_content',
            'label'   => __( 'Search in description', 'ajax-search-for-woocommerce' ),
            'type'    => 'checkbox',
            'default' => 'off',
        ),
            100 => array(
            'name'    => 'search_in_product_excerpt',
            'label'   => __( 'Search in short description', 'ajax-search-for-woocommerce' ),
            'type'    => 'checkbox',
            'default' => 'off',
        ),
            150 => array(
            'name'    => 'search_in_product_sku',
            'label'   => __( 'Search in SKU', 'ajax-search-for-woocommerce' ),
            'type'    => 'checkbox',
            'desc'    => ( dgoraAsfwFs()->is_premium() ? __( 'Searching also in variable products SKU', 'ajax-search-for-woocommerce' ) : sprintf( __( 'Searching in variable products SKU is available only in <a target="_blank" href="%s">the pro version</a>.', 'ajax-search-for-woocommerce' ), Upgrade::getUpgradeUrl() ) ),
            'default' => 'off',
        ),
            200 => array(
            'name'    => 'search_in_product_attributes',
            'label'   => __( 'Search in attributes', 'ajax-search-for-woocommerce' ),
            'class'   => 'dgwt-wcas-premium-only',
            'type'    => 'checkbox',
            'default' => 'off',
        ),
            250 => array(
            'name'    => 'search_in_product_categories',
            'label'   => __( 'Search in categories', 'ajax-search-for-woocommerce' ),
            'class'   => 'js-dgwt-wcas-adv-settings dgwt-wcas-premium-only',
            'type'    => 'checkbox',
            'default' => 'off',
        ),
            275 => array(
            'name'    => 'search_in_product_tags',
            'label'   => __( 'Search in tags', 'ajax-search-for-woocommerce' ),
            'class'   => 'js-dgwt-wcas-adv-settings dgwt-wcas-premium-only',
            'type'    => 'checkbox',
            'default' => 'off',
        ),
            300 => array(
            'name'    => 'search_in_custom_fields',
            'label'   => __( 'Search in custom fields', 'ajax-search-for-woocommerce' ),
            'class'   => 'dgwt-wcas-premium-only',
            'type'    => 'text',
            'default' => '',
        ),
            350 => array(
            'name'    => 'exclude_out_of_stock',
            'label'   => __( "Exclude 'out of stock' products", 'ajax-search-for-woocommerce' ),
            'type'    => 'checkbox',
            'default' => 'off',
        ),
            400 => array(
            'name'  => 'search_scope_fuzziness_head',
            'label' => __( 'Fuzziness', 'ajax-search-for-woocommerce' ),
            'type'  => 'head',
            'class' => 'dgwt-wcas-sgs-header',
        ),
            500 => array(
            'name'  => 'search_synonyms_head',
            'label' => __( 'Synonyms', 'ajax-search-for-woocommerce' ),
            'type'  => 'head',
            'class' => 'dgwt-wcas-sgs-header js-dgwt-wcas-adv-settings',
        ),
            520 => array(
            'name'  => 'search_synonyms',
            'label' => __( 'Synonyms', 'ajax-search-for-woocommerce' ) . ' ' . Helpers::createQuestionMark( 'synonyms', __( "Synonyms feature allows your users to find more relevant results. If your products have alternative names and users often misspelling them, consider adding synonyms.", 'ajax-search-for-woocommerce' ) ),
            'type'  => 'textarea',
            'desc'  => __( 'Synonyms should be separated by a comma. Each new synonyms group in the new line. You can use a phrase instead of a single word. <br /> <br />Sample list:<br /> <br /><span class="dgwt-wcas-synonyms-sample">sofa, couch, davenport, divan, settee<br />big, grand, great, large, outsize</span>', 'ajax-search-for-woocommerce' ),
            'class' => 'dgwt-wcas-settings-synonyms js-dgwt-wcas-adv-settings dgwt-wcas-premium-only',
        ),
            600 => array(
            'name'  => 'filter_products_head',
            'label' => __( 'Exclude products', 'ajax-search-for-woocommerce' ),
            'type'  => 'head',
            'class' => 'dgwt-wcas-sgs-header js-dgwt-wcas-adv-settings',
        ),
            650 => array(
            'name'    => 'filter_products_rules',
            'label'   => __( 'Filters', 'ajax-search-for-woocommerce' ) . ' ' . Helpers::createQuestionMark(
            'filter_products_head',
            __( 'Exclude from search all products that match conditions', 'ajax-search-for-woocommerce' ),
            '',
            'right'
        ),
            'type'    => 'filters_rules_plug',
            'class'   => 'js-dgwt-wcas-adv-settings dgwt-wcas-premium-only',
            'default' => array(),
        ),
        ) ),
            'dgwt_wcas_performance'  => apply_filters( 'dgwt/wcas/settings/section=performance', array(
            0   => array(
            'name'  => 'pro_features',
            'label' => __( 'Pro features', 'ajax-search-for-woocommerce' ),
            'type'  => 'desc',
            'desc'  => Helpers::featuresHtml(),
        ),
            10  => array(
            'name'  => 'search_engine_head',
            'label' => __( 'Speed up search!', 'ajax-search-for-woocommerce' ),
            'type'  => 'head',
            'class' => 'dgwt-wcas-sgs-header',
        ),
            100 => array(
            'name'  => 'indexer_schedule_head',
            'label' => __( 'Scheduling Indexing', 'ajax-search-for-woocommerce' ),
            'type'  => 'head',
            'class' => 'dgwt-wcas-sgs-header js-dgwt-wcas-adv-settings',
        ),
            110 => array(
            'name'    => 'indexer_schedule',
            'label'   => __( 'Enable Scheduler', 'ajax-search-for-woocommerce' ) . ' ' . Helpers::createQuestionMark( 'indexer-schedule', __( "I most cases you don't need to use the scheduler because The search index is updating when you edit products. If you use import tools or custom code to refresh prices or bulk add/edit products, the indexing scheduler will be helpful.", 'ajax-search-for-woocommerce' ) ),
            'type'    => 'checkbox',
            'size'    => 'small',
            'class'   => 'dgwt-wcas-options-cb-toggle js-dgwt-wcas-cbtgroup-indexer-schedule js-dgwt-wcas-adv-settings dgwt-wcas-premium-only',
            'default' => 'off',
        ),
            120 => array(
            'name'    => 'indexer_schedule_interval',
            'label'   => __( 'Interval', 'ajax-search-for-woocommerce' ),
            'type'    => 'select',
            'class'   => 'js-dgwt-wcas-cbtgroup-indexer-schedule js-dgwt-wcas-adv-settings dgwt-wcas-premium-only',
            'options' => array(
            'daily'  => __( 'Daily', 'ajax-search-for-woocommerce' ),
            'weekly' => __( 'Weekly', 'ajax-search-for-woocommerce' ),
        ),
            'default' => 'weekly',
        ),
            130 => array(
            'name'    => 'indexer_schedule_start_time',
            'label'   => __( 'What time to rebuild the index?', 'ajax-search-for-woocommerce' ),
            'type'    => 'select',
            'class'   => 'js-dgwt-wcas-cbtgroup-indexer-schedule js-dgwt-wcas-adv-settings dgwt-wcas-premium-only',
            'options' => Helpers::getHours(),
            'default' => 3,
        ),
        ) ),
        );
        $fuzzinesText1 = '<strong>' . __( 'Increases sales conversions', 'ajax-search-for-woocommerce' ) . '</strong>';
        $fuzzinesText2 = __( 'Returns suggestions based on likely relevance even though a search keyword may not exactly match. E.g if you type "ipho<b>m</b>e" you get the same results as for "iphone"', 'ajax-search-for-woocommerce' );
        
        if ( dgoraAsfwFs()->is_premium() ) {
        } else {
            // Fuzzy search feature preview
            $settingsFields['dgwt_wcas_search'][450] = array(
                'name'    => 'fuzziness_enabled_demo',
                'label'   => __( 'Fuzzy matching', 'ajax-search-for-woocommerce' ),
                'desc'    => $fuzzinesText1 . ' ' . $fuzzinesText2,
                'class'   => 'dgwt-wcas-premium-only',
                'type'    => 'select',
                'options' => array(
                'off'    => __( '-- Disabled', 'ajax-search-for-woocommerce' ),
                'soft'   => __( 'Soft', 'ajax-search-for-woocommerce' ),
                'normal' => __( 'Normal', 'ajax-search-for-woocommerce' ),
                'hard'   => __( 'Hard', 'ajax-search-for-woocommerce' ),
            ),
                'default' => 'off',
            );
            // Indexer feature preview
            $settingsFields['dgwt_wcas_performance'][11] = array(
                'name'  => 'search_engine_build',
                'label' => __( 'Index status', 'ajax-search-for-woocommerce' ),
                'type'  => 'desc',
                'desc'  => Helpers::indexerDemoHtml(),
                'class' => 'dgwt-wcas-premium-only wcas-opt-tntsearch',
            );
        }
        
        foreach ( $settingsFields as $key => $sections ) {
            foreach ( $sections as $option ) {
                if ( !empty($option['name']) ) {
                    $this->defaults[$option['name']] = ( isset( $option['default'] ) ? $option['default'] : '' );
                }
            }
        }
        if ( !dgoraAsfwFs()->is_premium() ) {
            foreach ( $settingsFields as $key => $sections ) {
                foreach ( $sections as $keyl2 => $option ) {
                    if ( self::isOptionPremium( $option ) ) {
                        $settingsFields[$key][$keyl2]['label'] = Helpers::getSettingsProLabel( $option['label'], 'option-label' );
                    }
                }
            }
        }
        $settingsFields = apply_filters( 'dgwt/wcas/settings', $settingsFields );
        foreach ( $settingsFields as $key => $sections ) {
            ksort( $settingsFields[$key] );
        }
        return $settingsFields;
    }
    
    /*
     * Option value
     *
     * @param string $option_key
     * @param string $default default value if option not exist
     *
     * @return string
     */
    public function getOption( $option_key, $default = '' )
    {
        $value = '';
        
        if ( is_string( $option_key ) && !empty($option_key) ) {
            
            if ( !empty($this->settingsCache) ) {
                $settings = $this->settingsCache;
            } else {
                $settings = get_option( $this->settingSlug );
            }
            
            
            if ( !empty($settings) && is_array( $settings ) ) {
                $this->settingsCache = $settings;
                
                if ( array_key_exists( $option_key, $settings ) ) {
                    $value = $settings[$option_key];
                } else {
                    // Catch default
                    if ( empty($default) ) {
                        foreach ( $this->defaults as $key => $defaultValue ) {
                            if ( $key === $option_key ) {
                                $value = $defaultValue;
                            }
                        }
                    }
                }
            
            }
        
        }
        
        if ( $value === '' && !empty($default) ) {
            $value = $default;
        }
        $value = apply_filters( 'dgwt/wcas/settings/load_value', $value, $option_key );
        $value = apply_filters( 'dgwt/wcas/settings/load_value/key=' . $option_key, $value );
        return $value;
    }
    
    /*
     * Update option
     *
     * @param string $option_key
     * @param string $value
     *
     * @return bool
     */
    public function updateOpt( $optionKey, $value = '' )
    {
        $updated = false;
        
        if ( is_string( $optionKey ) && !empty($optionKey) ) {
            $settings = get_option( $this->settingSlug );
            $value = apply_filters( 'dgwt/wcas/settings/update_value', $value, $optionKey );
            $value = apply_filters( 'dgwt/wcas/settings/update_value/key=' . $optionKey, $value );
            $canUpdate = false;
            
            if ( array_key_exists( $optionKey, $this->defaults ) ) {
                $settings[$optionKey] = $value;
                $canUpdate = true;
            }
            
            if ( $canUpdate ) {
                $updated = update_option( $this->settingSlug, $settings );
            }
        }
        
        return $updated;
    }
    
    /**
     * Handles output of the settings
     */
    public static function output()
    {
        $settings = DGWT_WCAS()->settings->settingsApi;
        include_once DGWT_WCAS_DIR . 'partials/admin/settings.php';
    }
    
    /**
     * Restore default option value
     *
     * @param mixed $value
     * @param mixed $default
     * @param array $option
     *
     * @return mixed
     */
    public function restoreDefaultValueForFreePlan( $value, $default, $option )
    {
        if ( !dgoraAsfwFs()->is_premium() ) {
            if ( self::isOptionPremium( $option ) ) {
                $value = $default;
            }
        }
        return $value;
    }
    
    /**
     * Check if user can see advanced settings
     *
     * @return bool
     */
    public function canSeeAdvSettings()
    {
        $canSee = false;
        
        if ( is_bool( $this->canSeeAdvSettings ) ) {
            $canSee = $this->canSeeAdvSettings;
        } else {
            $settings = get_option( 'dgwt_wcas_settings_show_advanced' );
            
            if ( !empty($settings) ) {
                
                if ( $settings === 'on' ) {
                    $canSee = true;
                } elseif ( $settings === 'off' ) {
                    $canSee = false;
                }
                
                $this->canSeeAdvSettings = $canSee;
            }
        
        }
        
        return $canSee;
    }
    
    /**
     * Toggle visibility of advanced settings
     * Ajax endpoint
     *
     * @return void
     */
    public function toggleAdvancedSettings()
    {
        $show = ( !empty($_GET['adv_settings_value']) && $_GET['adv_settings_value'] === 'show' ? 'on' : 'off' );
        update_option( 'dgwt_wcas_settings_show_advanced', $show );
        wp_send_json_success();
    }
    
    /**
     * Check if a option is premium
     *
     * @param array $option
     *
     * @return bool
     */
    public static function isOptionPremium( $option )
    {
        $is_premium = false;
        if ( !empty($option['class']) && strpos( $option['class'], 'dgwt-wcas-premium-only' ) !== false ) {
            $is_premium = true;
        }
        return $is_premium;
    }

}