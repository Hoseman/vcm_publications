<?php

namespace DgoraWcas\Admin;

use  DgoraWcas\Helpers ;
use  DgoraWcas\Engines\TNTSearchMySQL\Indexer\Builder ;
use  DgoraWcas\Multilingual ;
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class Troubleshooting
{
    const  SECTION_ID = 'dgwt_wcas_troubleshooting' ;
    const  TRANSIENT_RESULTS_KEY = 'dgwt_wcas_troubleshooting_async_results' ;
    const  ASYNC_TEST_NONCE = 'troubleshooting-async-test' ;
    const  RESET_ASYNC_TESTS_NONCE = 'troubleshooting-reset-async-tests' ;
    public function __construct()
    {
        if ( !$this->checkRequirements() ) {
            return;
        }
        add_filter( 'dgwt/wcas/settings', array( $this, 'addSettingsTab' ) );
        add_filter( 'dgwt/wcas/settings/sections', array( $this, 'addSettingsSection' ) );
        add_filter( 'dgwt/wcas/scripts/admin/localize', array( $this, 'localizeSettings' ) );
        add_action( DGWT_WCAS_SETTINGS_KEY . '-form_bottom_' . self::SECTION_ID, array( $this, 'tabContent' ) );
        add_action( 'wp_ajax_dgwt_wcas_troubleshooting_test', array( $this, 'asyncTest' ) );
        add_action( 'wp_ajax_dgwt_wcas_troubleshooting_reset_async_tests', array( $this, 'resetAsyncTests' ) );
    }
    
    /**
     * Add "Troubleshooting" tab on Settings page
     *
     * @param array $settings
     *
     * @return array
     */
    public function addSettingsTab( $settings )
    {
        $settings[self::SECTION_ID] = apply_filters( 'dgwt/wcas/settings/section=troubleshooting', array(
            10 => array(
            'name'  => 'troubleshooting_head',
            'label' => __( 'Troubleshooting', 'ajax-search-for-woocommerce' ),
            'type'  => 'head',
            'class' => 'dgwt-wcas-sgs-header',
        ),
        ) );
        return $settings;
    }
    
    /**
     * Content of "Troubleshooting" tab on Settings page
     *
     * @param array $sections
     *
     * @return array
     */
    public function addSettingsSection( $sections )
    {
        $sections[35] = array(
            'id'    => self::SECTION_ID,
            'title' => __( 'Troubleshooting', 'ajax-search-for-woocommerce' ) . '<span class="js-dgwt-wcas-troubleshooting-count dgwt-wcas-troubleshooting-count"></span>',
        );
        return $sections;
    }
    
    /**
     * AJAX callback for running async test
     */
    public function asyncTest()
    {
        check_ajax_referer( self::ASYNC_TEST_NONCE );
        $test = ( isset( $_POST['test'] ) ? $_POST['test'] : '' );
        if ( !$this->isTestExists( $test ) ) {
            wp_send_json_error();
        }
        $testFunction = sprintf( 'getTest%s', $test );
        
        if ( method_exists( $this, $testFunction ) && is_callable( array( $this, $testFunction ) ) ) {
            $data = $this->performTest( array( $this, $testFunction ) );
            wp_send_json_success( $data );
        }
        
        wp_send_json_error();
    }
    
    /**
     * Reset stored results of async tests
     */
    public function resetAsyncTests()
    {
        check_ajax_referer( self::RESET_ASYNC_TESTS_NONCE );
        delete_transient( self::TRANSIENT_RESULTS_KEY );
        wp_send_json_success();
    }
    
    /**
     * Pass "troubleshooting" data to JavaScript on Settings page
     *
     * @param array $localize
     *
     * @return array
     */
    public function localizeSettings( $localize )
    {
        $localize['troubleshooting'] = array(
            'nonce' => array(
            'troubleshooting_async_test'        => wp_create_nonce( self::ASYNC_TEST_NONCE ),
            'troubleshooting_reset_async_tests' => wp_create_nonce( self::RESET_ASYNC_TESTS_NONCE ),
        ),
            'tests' => array(
            'direct'        => array(),
            'async'         => array(),
            'issues'        => array(
            'good'        => 0,
            'recommended' => 0,
            'critical'    => 0,
        ),
            'results_async' => array(),
        ),
        );
        $asyncTestsResults = get_transient( self::TRANSIENT_RESULTS_KEY );
        
        if ( !empty($asyncTestsResults) && is_array( $asyncTestsResults ) ) {
            $localize['troubleshooting']['tests']['results_async'] = array_values( $asyncTestsResults );
            foreach ( $asyncTestsResults as $result ) {
                $localize['troubleshooting']['tests']['issues'][$result['status']]++;
            }
        }
        
        $tests = Troubleshooting::getTests();
        if ( !empty($tests['direct']) && is_array( $tests['direct'] ) ) {
            foreach ( $tests['direct'] as $test ) {
                
                if ( is_string( $test['test'] ) ) {
                    $testFunction = sprintf( 'getTest%s', $test['test'] );
                    
                    if ( method_exists( $this, $testFunction ) && is_callable( array( $this, $testFunction ) ) ) {
                        $localize['troubleshooting']['tests']['direct'][] = $this->performTest( array( $this, $testFunction ) );
                        continue;
                    }
                
                }
                
                if ( is_callable( $test['test'] ) ) {
                    $localize['troubleshooting']['tests']['direct'][] = $this->performTest( $test['test'] );
                }
            }
        }
        if ( !empty($localize['troubleshooting']['tests']['direct']) && is_array( $localize['troubleshooting']['tests']['direct'] ) ) {
            foreach ( $localize['troubleshooting']['tests']['direct'] as $result ) {
                $localize['troubleshooting']['tests']['issues'][$result['status']]++;
            }
        }
        if ( !empty($tests['async']) && is_array( $tests['async'] ) ) {
            foreach ( $tests['async'] as $test ) {
                if ( is_string( $test['test'] ) ) {
                    $localize['troubleshooting']['tests']['async'][] = array(
                        'test'      => $test['test'],
                        'completed' => isset( $asyncTestsResults[$test['test']] ),
                    );
                }
            }
        }
        return $localize;
    }
    
    /**
     * Load content for "Troubleshooting" tab on Settings page
     */
    public function tabContent()
    {
        require DGWT_WCAS_DIR . 'partials/admin/troubleshooting.php';
    }
    
    /**
     * Test for incompatible plugins
     *
     * @return array The test result.
     */
    public function getTestIncompatiblePlugins()
    {
        $result = array(
            'label'       => __( 'You are using one or more incompatible plugins', 'ajax-search-for-woocommerce' ),
            'status'      => 'good',
            'description' => '',
            'actions'     => '',
            'test'        => 'IncompatiblePlugins',
        );
        $errors = array();
        // GTranslate
        if ( class_exists( 'GTranslate' ) ) {
            $errors[] = sprintf( __( 'You use the %s plugin. The Ajax Search for WooCommerce does not support this plugin.', 'ajax-search-for-woocommerce' ), 'GTranslate' );
        }
        // WooCommerce Product Sort and Display
        if ( defined( 'WC_PSAD_VERSION' ) ) {
            $errors[] = sprintf( __( 'You use the %s plugin. The Ajax Search for WooCommerce does not support this plugin.', 'ajax-search-for-woocommerce' ), 'WooCommerce Product Sort and Display' );
        }
        
        if ( !empty($errors) ) {
            $result['description'] = join( '<br>', $errors );
            $result['status'] = 'critical';
        }
        
        return $result;
    }
    
    /**
     * Test if loopbacks work as expected
     *
     * @return array The test result.
     */
    public function getTestLoopbackRequests()
    {
        $result = array(
            'label'       => __( 'Your site can perform loopback requests', 'ajax-search-for-woocommerce' ),
            'status'      => 'good',
            'description' => '',
            'actions'     => '',
            'test'        => 'LoopbackRequests',
        );
        $cookies = array();
        $timeout = 10;
        $headers = array(
            'Cache-Control' => 'no-cache',
        );
        /** This filter is documented in wp-includes/class-wp-http-streams.php */
        $sslverify = apply_filters( 'https_local_ssl_verify', false );
        $authorization = Helpers::getBasicAuthHeader();
        if ( $authorization ) {
            $headers['Authorization'] = $authorization;
        }
        $url = home_url();
        $r = wp_remote_get( $url, compact(
            'cookies',
            'headers',
            'timeout',
            'sslverify'
        ) );
        $markAsCritical = is_wp_error( $r ) || wp_remote_retrieve_response_code( $r ) !== 200;
        // Exclude timeout error
        if ( is_wp_error( $r ) && $r->get_error_code() === 'http_request_failed' && strpos( strtolower( $r->get_error_message() ), 'curl error 28:' ) !== false ) {
            $markAsCritical = false;
        }
        
        if ( $markAsCritical ) {
            $result['status'] = 'critical';
            $result['label'] = __( 'Your site could not complete a loopback request', 'ajax-search-for-woocommerce' );
            if ( !dgoraAsfwFs()->is_premium() ) {
                $result['description'] = __( 'This issue may affect the search results page and e.g. display all products every time', 'ajax-search-for-woocommerce' );
            }
            $result['description'] .= '<h3 class="dgwt-wcas-font-thin">' . __( 'Solutions:', 'ajax-search-for-woocommerce' ) . '</h3>';
            $result['description'] .= '<h4>' . __( 'Do you have a Basic Auth?', 'ajax-search-for-woocommerce' ) . '</h4>';
            $result['description'] .= '<p>' . __( 'If yes, you have to add to your <code>wp-config.php</code> file following constants. Remember to replace <code>your-username</code> and <code>your-password</code> with your values.', 'ajax-search-for-woocommerce' ) . '</p>';
            $result['description'] .= '<pre style="margin-top: 10px">define(\'DGWT_WCAS_BA_USERNAME\', \'your-username\');';
            $result['description'] .= '</br>define(\'DGWT_WCAS_BA_PASSWORD\', \'your-password\');</pre>';
            $result['description'] .= '<h4 style="margin-top: 15px">' . __( 'Is your website publicly available only for whitelisted IPs?', 'ajax-search-for-woocommerce' ) . '</h4>';
            $result['description'] .= '<p>' . __( 'If yes, add you server IP to whitelist IPs. That’s all.', 'ajax-search-for-woocommerce' ) . '</p>';
        }
        
        $this->storeResult( $result );
        return $result;
    }
    
    /**
     * Test for required PHP extensions
     *
     * @return array The test result.
     */
    public function getTestPHPExtensions()
    {
        $result = array(
            'label'       => __( 'One or more required PHP extensions are missing on your server', 'ajax-search-for-woocommerce' ),
            'status'      => 'good',
            'description' => '',
            'actions'     => '',
            'test'        => 'PHPExtensions',
        );
        $errors = array();
        if ( !extension_loaded( 'mbstring' ) ) {
            $errors[] = sprintf( __( 'Required PHP extension: %s', 'ajax-search-for-woocommerce' ), 'mbstring' );
        }
        if ( !extension_loaded( 'pdo_mysql' ) ) {
            $errors[] = sprintf( __( 'Required PHP extension: %s', 'ajax-search-for-woocommerce' ), 'pdo_mysql' );
        }
        
        if ( !empty($errors) ) {
            $result['description'] = join( '<br>', $errors );
            $result['status'] = 'critical';
        }
        
        return $result;
    }
    
    /**
     * Tests for WordPress version and outputs it.
     *
     * @return array The test result.
     */
    public function getTestWordPressVersion()
    {
        $result = array(
            'label'       => __( 'WordPress version', 'ajax-search-for-woocommerce' ),
            'status'      => '',
            'description' => '',
            'actions'     => '',
            'test'        => 'WordPressVersion',
        );
        $coreCurrentVersion = get_bloginfo( 'version' );
        
        if ( version_compare( $coreCurrentVersion, '5.2.0' ) >= 0 ) {
            $result['description'] = __( 'Great! Our plugin works great with this version of WordPress.', 'ajax-search-for-woocommerce' );
            $result['status'] = 'good';
        } else {
            $result['description'] = __( 'Install the latest version of WordPress for our plugin to work as best it can!', 'ajax-search-for-woocommerce' );
            $result['status'] = 'critical';
        }
        
        return $result;
    }
    
    /**
     * Tests for required "Add to cart" behaviour in WooCommerce settings
     * If the search Details Panel is enabled, WooCommerce "Add to cart" behaviour should be enabled.
     *
     * @return array The test result.
     */
    public function getTestAjaxAddToCart()
    {
        $result = array(
            'label'       => '',
            'status'      => 'good',
            'description' => '',
            'actions'     => '',
            'test'        => 'AjaxAddToCart',
        );
        
        if ( 'on' === DGWT_WCAS()->settings->getOption( 'show_details_box' ) && ('yes' !== get_option( 'woocommerce_enable_ajax_add_to_cart' ) || 'yes' === get_option( 'woocommerce_cart_redirect_after_add' )) ) {
            $redirectLabel = __( 'Redirect to the cart page after successful addition', 'woocommerce' );
            $ajaxAtcLabel = __( 'Enable AJAX add to cart buttons on archives', 'woocommerce' );
            $settingsUrl = admin_url( 'admin.php?page=wc-settings&tab=products' );
            $result['label'] = __( 'Incorrect "Add to cart" behaviour in WooCommerce settings', 'ajax-search-for-woocommerce' );
            $result['description'] = '<p><b>' . __( 'Solution', 'ajax-search-for-woocommerce' ) . '</b></p>';
            $result['description'] .= '<p>' . sprintf(
                __( 'Go to <code>WooCommerce -> Settings -> <a href="%s" target="_blank">Products (tab)</a></code> and check option <code>%s</code> and uncheck option <code>%s</code>.', 'ajax-search-for-woocommerce' ),
                $settingsUrl,
                $ajaxAtcLabel,
                $redirectLabel
            ) . '</p>';
            $result['description'] .= __( 'Your settings should looks like the picture below:', 'ajax-search-for-woocommerce' );
            $result['description'] .= '<p><img style="max-width: 720px" src="' . DGWT_WCAS_URL . 'assets/img/admin-troubleshooting-atc.png" /></p>';
            $result['status'] = 'critical';
        }
        
        return $result;
    }
    
    /**
     * Tests if "Searching by Text" extension from WOOF - WooCommerce Products Filter is enabled.
     * It's incompatible with our plugin and should be disabled.
     *
     * @return array The test result.
     */
    public function getTestWoofSearchTextExtension()
    {
        $result = array(
            'label'       => '',
            'status'      => 'good',
            'description' => '',
            'actions'     => '',
            'test'        => 'WoofSearchTextExtension',
        );
        if ( !defined( 'WOOF_VERSION' ) || !isset( $GLOBALS['WOOF'] ) ) {
            return $result;
        }
        if ( !method_exists( 'WOOF_EXT', 'is_ext_activated' ) ) {
            return $result;
        }
        $extDirs = $GLOBALS['WOOF']->get_ext_directories();
        if ( empty($extDirs['default']) ) {
            return $result;
        }
        $extPaths = array_filter( $extDirs['default'], function ( $path ) {
            return strpos( $path, 'ext/by_text' ) !== false;
        } );
        if ( empty($extPaths) ) {
            return $result;
        }
        $extPath = array_shift( $extPaths );
        
        if ( \WOOF_EXT::is_ext_activated( $extPath ) ) {
            $settingsUrl = admin_url( 'admin.php?page=wc-settings&tab=woof' );
            $result['label'] = __( 'Incompatible "Searching by Text" extension from WOOF - WooCommerce Products Filter plugin is active', 'ajax-search-for-woocommerce' );
            $result['description'] = '<p><b>' . __( 'Solution', 'ajax-search-for-woocommerce' ) . '</b></p>';
            $result['description'] .= '<p>' . sprintf( __( 'Go to <code>WooCommerce -> Settings -> <a href="%s" target="_blank">Products Filter (tab)</a> -> Extensions (tab)</code>, uncheck <code>Searching by Text</code> extension and save changes.', 'ajax-search-for-woocommerce' ), $settingsUrl ) . '</p>';
            $result['description'] .= __( 'Extensions should looks like the picture below:', 'ajax-search-for-woocommerce' );
            $result['description'] .= '<p><img style="max-width: 720px" src="' . DGWT_WCAS_URL . 'assets/img/admin-troubleshooting-woof.png" /></p>';
            $result['status'] = 'critical';
        }
        
        return $result;
    }
    
    /**
     * Return a set of tests
     *
     * @return array The list of tests to run.
     */
    public static function getTests()
    {
        $tests = array(
            'direct' => array(
            array(
            'label' => __( 'WordPress version', 'ajax-search-for-woocommerce' ),
            'test'  => 'WordPressVersion',
        ),
            array(
            'label' => __( 'PHP extensions', 'ajax-search-for-woocommerce' ),
            'test'  => 'PHPExtensions',
        ),
            array(
            'label' => __( 'Incompatible plugins', 'ajax-search-for-woocommerce' ),
            'test'  => 'IncompatiblePlugins',
        ),
            array(
            'label' => __( 'Incorrect "Add to cart" behaviour in WooCommerce settings', 'ajax-search-for-woocommerce' ),
            'test'  => 'AjaxAddToCart',
        ),
            array(
            'label' => __( 'Incompatible "Searching by Text" extension in WOOF - WooCommerce Products Filter', 'ajax-search-for-woocommerce' ),
            'test'  => 'WoofSearchTextExtension',
        )
        ),
            'async'  => array( array(
            'label' => __( 'Loopback request', 'ajax-search-for-woocommerce' ),
            'test'  => 'LoopbackRequests',
        ) ),
        );
        if ( !dgoraAsfwFs()->is_premium() ) {
            // List of tests only for free plugin version
        }
        $tests = apply_filters( 'dgwt/wcas/troubleshooting/tests', $tests );
        return $tests;
    }
    
    /**
     * Check requirements
     *
     * We need WordPress 5.4 from which the Site Health module is available.
     *
     * @return bool
     */
    private function checkRequirements()
    {
        global  $wp_version ;
        return version_compare( $wp_version, '5.4.0' ) >= 0;
    }
    
    /**
     * Run test directly
     *
     * @param $callback
     *
     * @return mixed|void
     */
    private function performTest( $callback )
    {
        return apply_filters( 'dgwt/wcas/troubleshooting/test-result', call_user_func( $callback ) );
    }
    
    /**
     * Check if test exists
     *
     * @param $test
     *
     * @return bool
     */
    private function isTestExists( $test, $type = 'async' )
    {
        if ( empty($test) ) {
            return false;
        }
        $tests = self::getTests();
        foreach ( $tests[$type] as $value ) {
            if ( $value['test'] === $test ) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Get table with server environment
     *
     * @return string
     */
    private function getDebugData()
    {
        if ( !class_exists( 'WP_Debug_Data' ) ) {
            require_once ABSPATH . 'wp-admin/includes/class-wp-debug-data.php';
        }
        $result = '';
        $info = \WP_Debug_Data::debug_data();
        
        if ( isset( $info['wp-server']['fields'] ) ) {
            ob_start();
            ?>
			<p><b><?php 
            _e( 'Server environment', 'ajax-search-for-woocommerce' );
            ?></b></p>
			<table class="widefat striped" role="presentation">
				<tbody>
				<?php 
            foreach ( $info['wp-server']['fields'] as $field_name => $field ) {
                
                if ( is_array( $field['value'] ) ) {
                    $values = '<ul>';
                    foreach ( $field['value'] as $name => $value ) {
                        $values .= sprintf( '<li>%s: %s</li>', esc_html( $name ), esc_html( $value ) );
                    }
                    $values .= '</ul>';
                } else {
                    $values = esc_html( $field['value'] );
                }
                
                printf( '<tr><td>%s</td><td>%s</td></tr>', esc_html( $field['label'] ), $values );
            }
            ?>
				</tbody>
			</table>
			<?php 
            $result = ob_get_clean();
        }
        
        return $result;
    }
    
    /**
     * Get result of async test
     *
     * @param string $test Test name
     *
     * @return array
     */
    private function getResult( $test )
    {
        $asyncTestsResults = get_transient( self::TRANSIENT_RESULTS_KEY );
        if ( isset( $asyncTestsResults[$test] ) ) {
            return $asyncTestsResults[$test];
        }
        return array();
    }
    
    /**
     * Storing result of async test
     *
     * Direct tests do not need to be saved.
     *
     * @param $result
     */
    private function storeResult( $result )
    {
        $asyncTestsResults = get_transient( self::TRANSIENT_RESULTS_KEY );
        if ( !is_array( $asyncTestsResults ) ) {
            $asyncTestsResults = array();
        }
        $asyncTestsResults[$result['test']] = $result;
        set_transient( self::TRANSIENT_RESULTS_KEY, $asyncTestsResults, 15 * 60 );
    }

}