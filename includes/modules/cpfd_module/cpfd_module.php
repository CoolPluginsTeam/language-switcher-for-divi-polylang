<?php

class CPFD_Module extends ET_Builder_Module {

	public $slug                   = 'connect-polylang-for-divi';
	public $vb_support             = 'on';
	private static $language_index = 0;

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'Coolplugins',
		'author_uri' => 'http://coolplugins.net/',
	);


	public function init() {
		$this->name = esc_html__( 'Language Switcher', 'cpfd' );

		 // Toggle settings
		 $this->settings_modal_toggles = array(
			 'general'  => array(
				 'toggles' => array(
					 'main_content' => array(
						 'title' => esc_html__( 'Language Switcher', 'cpfd' ),
					 ),
				 ),
			 ),
			 'advanced' => array(
				 'toggles' => array(
					 'cpfd_flag_settings'       => array(
						 'title' => esc_html__( 'Flag', 'cpfd' ),
					 ),
					 'cpfd_text_settings'       => array(
						 'title' => esc_html__( 'Text', 'cpfd' ),
					 ),
					 'cpfd_background'          => array(
						 'title' => esc_html__( 'Background', 'cpfd' ),
					 ),
					 'cpfd_dropdown_background' => array(
						 'title' => esc_html__( 'Dropwdown Background', 'cpfd' ),
					 ),
				 ),
			 ),
		 );
	}

	public function get_advanced_fields_config() {

		$advanced_fields                   = array();
		$advanced_fields['background']     = false;
		$advanced_fields['animation']      = false;
		$advanced_fields['text']           = false;
		$advanced_fields['margin_padding'] = false;
		$advanced_fields['transform']      = false;
		// $advanced_fields['filters']         = false;
		$advanced_fields['box_shadow']     = false;
		$advanced_fields['border']     	   = false;
		// $advanced_fields['max_width'] 	   = false;
		$advanced_fields['fonts']['cpfd_text_settings'] = array(
			'label_prefix'        => esc_html__( 'Text', 'cpfd' ),
			'tab_slug'            => 'advanced',
			'toggle_slug'         => 'cpfd_text_settings',
			'css'          => array(
				'main'      => '%%order_class%% .cpfd-wrapper ul li.cpfd_active_lang .cpfd-lang-name, %%order_class%% .cpfd-wrapper ul li.cpfd_active_lang .cpfd-lang-code,   %%order_class%% .cpfd-wrapper ul li .cpfd-lang-name, %%order_class%% .cpfd-wrapper ul li .cpfd-lang-code, %%order_class%% .cpfd-wrapper.dropdown span .cpfd-lang-name, %%order_class%% .cpfd-wrapper.dropdown span .cpfd-lang-code, %%order_class%% .cpfd-wrapper ul li a,',
				'important' => 'all',
			),
			'hide_text_align'     => true,
			'hide_text_shadow'    => true,
		);
		// Configure the margin and padding for the container.
		$advanced_fields['margin_padding'] = array(
			'css'          => array(
				'main'      => '%%order_class%% .cpfd-wrapper ul li a, %%order_class%% .cpfd-wrapper.dropdown',
				'important' => true,
			),
			'toggle_slug'  => 'cpfd_background',
			'tab_slug'     => 'advanced',
		);

		return $advanced_fields;
	}

	public function get_fields() {
		return array(
			'cpfd_style'                         => array(
				'label'       => esc_html__( 'Layout Options', 'cpfd' ),
				'type'        => 'select',
				'default'     => 'dropdown',
				'options'     => array(
					'vertical'   => esc_html__( 'Vertical', 'cpfd' ),
					'horizontal' => esc_html__( 'Horizontal', 'cpfd' ),
					'dropdown'   => esc_html__( 'Dropdown', 'cpfd' ),
				),
				'toggle_slug' => 'main_content',
			),
			'cpfd_flag_visibility'               => array(
				'label'       => esc_html__( 'Display Flag', 'cpfd' ),
				'type'        => 'yes_no_button',
				'default'     => 'on',
				'options'     => array('on','off'),
				'toggle_slug' => 'main_content'
			),
			'cpfd_language_name_visibility'      => array(
				'label'       => esc_html__( 'Show Language Name', 'cpfd' ),
				'type'        => 'yes_no_button',
				'options'     => array('on','off'),
				'default'     => 'on',
				'toggle_slug' => 'main_content'
			),
			'cpfd_language_code_visibility'      => array(
				'label'       => esc_html__( 'Show Language Code', 'cpfd' ),
				'type'        => 'yes_no_button',
				'options'     => array('on','off'),
				'toggle_slug' => 'main_content'
			),
			'cpfd_current_lang_visibility'       => array(
				'label'       => esc_html__( 'Hide Current Language', 'cpfd' ),
				'type'        => 'yes_no_button',
				'options'     => array('on','off'),
				'toggle_slug' => 'main_content',
				'show_if'     => array(
					'cpfd_style' => array( 'horizontal', 'vertical' ),
				),
			),
			'cpfd_unstranslated_lang_visibility' => array(
				'label'       => esc_html__( 'Hide Untranslated Languages', 'cpfd' ),
				'type'        => 'yes_no_button',
				'options'     => array('on','off'),
				'toggle_slug' => 'main_content'
			),
			'cpfd_flag_ratio'                    => array(
				'label'       => esc_html__( 'Aspect Ratio', 'cpfd' ),
				'type'        => 'select',
				'default'     => 'auto',
				'options'     => array(
					'auto' => esc_html__( 'auto', 'cpfd' ),
					'1/1'  => esc_html__( '1:1', 'cpfd' ),
					'4/3'  => esc_html__( '4:3', 'cpfd' ),
				),
				'toggle_slug' => 'cpfd_flag_settings',
				'tab_slug'    => 'advanced'
			),
			'cpfd_flag_width'                    => array(
				'label'          => esc_html__( 'Flag Width', 'cpfd' ),
				'type'           => 'range',
				'default'        => '20px',
				'range_settings' => array(
					'min'  => '10px',
					'max'  => '100px',
					'step' => '1px',
				),
				'toggle_slug'    => 'cpfd_flag_settings',
				'tab_slug'       => 'advanced'
			),
			'cpfd_flag_radius'                   => array(
				'label'          => esc_html__( 'Flag Border Radius', 'cpfd' ),
				'type'           => 'range',
				'default'        => '0px',
				'range_settings' => array(
					'min'  => '0px',
					'max'  => '100px',
					'step' => '1px',
				),
				'toggle_slug'    => 'cpfd_flag_settings',
				'tab_slug'       => 'advanced'
			),

			'cpfd_bg_normal_color' => array(
				'label'       => esc_html__( 'Background', 'cpfd' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'cpfd_background',
				'type'        => 'color',
				'responsive'      => true,
				'mobile_options'  => true,
				'hover'           => 'tabs'
			),
		);
	}

	public function render( $attrs, $content = null, $render_slug = null ) {
			$static_style_loader = new CPFD_STYLE_HELPERS( $attrs, $render_slug, self::$language_index );
			self::$language_index++;
			$style                 = ! isset( $attrs['cpfd_style'] ) ? 'dropdown' : $attrs['cpfd_style'];
			$flag_display          = ! isset( $attrs['cpfd_flag_visibility'] ) ? 'on' : $attrs['cpfd_flag_visibility'];
			$name_display          = ! isset( $attrs['cpfd_language_name_visibility'] ) ? 'on' : $attrs['cpfd_language_name_visibility'];
			$code_display          = ! isset( $attrs['cpfd_language_code_visibility'] ) ? 'off' : $attrs['cpfd_language_code_visibility'];
			$hide_current_lang     = ! isset( $attrs['cpfd_current_lang_visibility'] ) ? 'off' : $attrs['cpfd_current_lang_visibility'];
			$hide_untranslate_lang = ! isset( $attrs['cpfd_unstranslated_lang_visibility'] ) ? 'off' : $attrs['cpfd_unstranslated_lang_visibility'];
			$display_content       = in_array( 'on', array( $flag_display, $name_display, $code_display ) ) || in_array( 'off', array( $hide_current_lang, $hide_untranslate_lang ) );

			if ( $display_content ) {

				$languages = pll_the_languages( array( 'raw' => 1 ) );
				$lang_curr = strtolower( pll_current_language() );

				$html        = '';
				$active_span = '';

				if ( $style === 'dropdown' ) {
					$active_flag_icon = CPFD_HELPERS::get_country_flag( $languages[ $lang_curr ]['flag'], $languages[ $lang_curr ]['name'] );
					$active_span       = '<span><a href="' . esc_url( $languages[ $lang_curr ]['url'] ) . '">';
					if ( 'on' === $flag_display ) {
						$active_span .= sprintf(
							'<div class="cpfd-lang-image">%s</div>',
							$active_flag_icon,
							esc_url( $languages[ $lang_curr ]['flag'] )
						);
					}

					if ( 'on' === $name_display ) {
						$active_span .= sprintf(
							'<div class="cpfd-lang-name">%s</div>',
							esc_html( $languages[ $lang_curr ]['name'] )
						);
					}

					if ( 'on' === $code_display ) {
						$active_span .= sprintf(
							'<div class="cpfd-lang-code">%s</div>',
							esc_html( $languages[ $lang_curr ]['slug'] )
						);
					}
					$active_span .= '</a></span>';
				}

				foreach ( $languages as $lang ) {

					if ( $lang_curr === $lang['slug'] && 'dropdown' === $style ) {
						continue;
					}

					if ( $lang_curr === $lang['slug'] && 'on' === $hide_current_lang ) {
						continue;
					}

					if ( $lang['no_translation'] && 'on' === $hide_untranslate_lang ) {
						continue;
					}
					$flag_icon    = CPFD_HELPERS::get_country_flag( $lang['flag'], $lang['name'] );
					$active_class = $lang_curr === $lang['slug'] ? 'cpfd_active_lang' : '';
					$html        .= '<li class="' . esc_attr( $active_class ) . '"><a href="' . esc_url( $lang['url'] ) . '">';
					if ( 'on' === $flag_display ) {
						$html .= sprintf(
							'<div class="cpfd-lang-image">%s</div>',
							$flag_icon,
							
						);
					}

					if ( 'on' === $name_display ) {
						$html .= sprintf(
							'<div class="cpfd-lang-name">%s</div>',
							esc_html( $lang['name'] ),
						);
					}

					if ( 'on' === $code_display ) {
						$html .= sprintf(
							'<div class="cpfd-lang-code">%s</div>',
							esc_html( $lang['slug'] ),
						);
					}
					$html .='</a></li>';
				}

				$output = sprintf(
					' <div id="cpfd-wrapper" class="cpfd-wrapper %1$s">
				%3$s
				<ul>
				%2$s
				</ul>
				</div>',
					esc_attr( $style ),
					$html,
					$active_span,
				);

				return $output;
			}
	}
}

new CPFD_Module();
