<?php
if (!defined('ABSPATH')) {
  exit;
} 
/**
 *
 * This page serve as dashboard template
 *
 */
// do not render this page if its found outside of main class
if( !isset($this->main_menu_slug) ){
  return false;
}
$lsdp_is_active = false;
$lsdp_classes = 'plugin-block';
$lsdp_is_installed = false;
$lsdp_button = null;
$lsdp_available_version = null;
$lsdp_update_available = false;
$lsdp_update_stats = '';
$lsdp_pro_already_installed = false;

// Let's see if a pro version is already installed
if( isset( $this->disable_plugins[ $lsdp_plugin_slug ] ) ){
    $lsdp_pro_version = $this->disable_plugins[ $lsdp_plugin_slug ];
    if( file_exists(WP_PLUGIN_DIR .'/' . $lsdp_pro_version['pro'] ) ){
        $lsdp_pro_already_installed = true;
        $lsdp_classes .= ' plugin-not-required';
    }
}

if (file_exists(WP_PLUGIN_DIR . '/' . $lsdp_plugin_slug)) {

    $lsdp_is_installed = true;
    $lsdp_plugin_file = null;
    $lsdp_installed_plugins = get_plugins();//get_option('active_plugins', false);
    $lsdp_is_active = false;
    $lsdp_classes .= ' installed-plugin';
    foreach ($lsdp_installed_plugins as $lsdp_plugin=>$lsdp_data) {
      $lsdp_thisPlugin = substr($lsdp_plugin,0,strpos($lsdp_plugin,'/'));
      if ( strcasecmp($lsdp_thisPlugin, $lsdp_plugin_slug) == 0 ) {

          if( isset($lsdp_plugin_version) && version_compare( $lsdp_plugin_version, $lsdp_data['Version'] ) >0 ){
            $lsdp_available_version = $lsdp_plugin_version ;
            $lsdp_plugin_version =  $lsdp_data['Version'];
            $lsdp_update_stats = '<span class="plugin-update-available">Update Available: v '.wp_kses_post($lsdp_available_version).'</span>';
          }

          if( is_plugin_active($lsdp_plugin) ){
            $lsdp_is_active = true;
            $lsdp_classes .= ' active-plugin';
            break;
          }else{
            $lsdp_plugin_file = $lsdp_plugin;
            $lsdp_classes .= ' inactive-plugin';
          }

        }
    }
    if( $lsdp_is_active ){
        $lsdp_button = '<button class="button button-disabled">Active</button>';
    }else{
        $lsdp_wp_nonce = wp_create_nonce( 'polylang-plugins-activate-' . $lsdp_plugin_slug );
        $lsdp_button .= '<button class="button activate-now cool-plugins-addon plugin-activator" data-plugin-tag="'.esc_attr($lsdp_tag).'" data-plugin-id="'.esc_attr($lsdp_plugin_file).'" 
        data-action-nonce="'.esc_attr($lsdp_wp_nonce).'" data-plugin-slug="'.esc_attr($lsdp_plugin_slug).'">Activate</button>';
    }
} else {
    $lsdp_wp_nonce = wp_create_nonce('polylang-plugins-download-' . $lsdp_plugin_slug );
    $lsdp_classes .= ' available-plugin';
    if( $lsdp_plugin_url !=null ){
      $lsdp_button = '<button class="button install-now cool-plugins-addon plugin-downloader" data-plugin-tag="'.esc_attr($lsdp_tag).'"  data-action-nonce="' .esc_attr($lsdp_wp_nonce) . '" data-plugin-slug="'.esc_attr($lsdp_plugin_slug).'">Install</button>';
    
    }elseif( isset($lsdp_plugin_pro_url) ){
      $lsdp_button = '<a class="button install-now cool-plugins-addon pro-plugin-downloader" href="'.esc_url($lsdp_plugin_pro_url).'" target="_new">Buy Pro</a>';
    }
}

// Remove install / activate button if pro version is already installed
if( $lsdp_pro_already_installed === true ){
  $lsdp_pro_ver = $this->disable_plugins[ $lsdp_plugin_slug ] ;
  $lsdp_button = '<button class="button button-disabled" title="This plugin is no more required as you already have '.esc_attr($lsdp_pro_ver['pro']).'">Pro Installed</button>';
}

    // All php condition formation is over here
?>



<div class="<?php echo esc_attr($lsdp_classes); ?>">
  <div class="plugin-block-inner">

    <div class="plugin-logo">
    <img src="<?php echo esc_url($lsdp_plugin_logo); ?>" width="250px" />
    </div>

    <div class="plugin-info">
      <h4 class="plugin-title"> <?php echo esc_html($lsdp_plugin_name); ?></h4>
      <div class="plugin-desc"><?php echo esc_html($lsdp_plugin_desc); ?></div>
      <div class="plugin-stats">
      <?php echo wp_kses_post($lsdp_button) ; ?> 
      <?php if( isset($lsdp_plugin_version) && !empty($lsdp_plugin_version)) : ?>
        <div class="plugin-version">v <?php echo esc_html($lsdp_plugin_version); ?></div>
        <?php echo wp_kses_post($lsdp_update_stats); ?>
      <?php endif; ?>
      </div>
    </div>

  </div>
</div>