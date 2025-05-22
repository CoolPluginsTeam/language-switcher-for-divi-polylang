<?php
/**
 * Get Started Page
 *
 * @package LanguageSwitcherPolylangDivi
 */

namespace LanguageSwitcherPolylangDivi\Admin;

if (!defined('ABSPATH')) {
    exit;
}

class LSDP_Get_Started {
    /**
     * Instance of this class
     *
     * @var object
     */
    public static $instance;

    /**
     * Constructor
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'lsdp_add_get_started_page'), 100);
        add_action('admin_enqueue_scripts', array($this, 'lsdp_enqueue_dashboard_scripts'));
    }

    /**
     * Add Get Started page under Polylang menu
     */
    public function lsdp_add_get_started_page() {
        add_submenu_page(
            'mlang',
            __('Get Started', 'language-switcher-for-divi-polylang'),
            __('Get Started', 'language-switcher-for-divi-polylang'),
            'manage_options',
            'lsdp-get-started',
            array($this, 'lsdp_get_started_page_content')
        );
    }

    /**
     * Enqueue dashboard scripts
     */
    public function lsdp_enqueue_dashboard_scripts(){
        wp_enqueue_style( 'lsdp-dashboard-style', plugin_dir_url( __FILE__ ) . '/css/admin-dashboard.css', null, LSDP );
    }

    /**
     * Get Started page content
     */
    public function lsdp_get_started_page_content() {
        ?>
        <div class="wrap lsdp-get-started">
            <h1><?php echo esc_html__('Welcome to Language Switcher for Divi & Polylang', 'language-switcher-for-divi-polylang'); ?></h1>
            
            <h2 class="nav-tab-wrapper">
                <a href="#getting-started" class="nav-tab nav-tab-active"><?php echo esc_html__('Getting Started', 'language-switcher-for-divi-polylang'); ?></a>
            </h2>

            <div class="lsdp-tab-content">
                <div id="getting-started" class="lsdp-tab-pane active">
                    <div class="lsdp-get-started-content">
                        <h3><?php echo esc_html__('Quick Start Guide', 'language-switcher-for-divi-polylang'); ?></h3>
                        <p><?php echo esc_html__('Thank you for installing Language Switcher for Divi & Polylang. This plugin allows you to add a language switcher to your Divi pages and menus.', 'language-switcher-for-divi-polylang'); ?></p>
                        
                        <h4><?php echo esc_html__('How to Use', 'language-switcher-for-divi-polylang'); ?></h4>
                        <ol>
                            <li><?php echo esc_html__('Make sure Polylang is installed and configured with your languages', 'language-switcher-for-divi-polylang'); ?></li>
                            <li><?php echo esc_html__('Edit your page or template with Divi', 'language-switcher-for-divi-polylang'); ?></li>
                            <li><?php echo esc_html__('Search for "Language Switcher" in the Divi modules panel', 'language-switcher-for-divi-polylang'); ?></li>
                            <li><?php echo esc_html__('Add the module where you want to display the language switcher', 'language-switcher-for-divi-polylang'); ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Get instance of this class
     *
     * @return object
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}

// Initialize the Get Started page
LSDP_Get_Started::get_instance(); 