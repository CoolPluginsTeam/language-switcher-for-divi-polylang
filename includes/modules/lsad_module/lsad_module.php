<?php

class LSAD_Module extends ET_Builder_Module {

	public $slug                   = 'language-switcher-addon-for-divi';
	public $vb_support             = 'on';
	private static $language_index = 0;

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'Coolplugins',
		'author_uri' => 'http://coolplugins.net/',
	);


	public function init() {
		$this->name = esc_html__( 'Language Switcher', 'language-switcher-addon-for-divi' );

		 // Toggle settings
		 $this->settings_modal_toggles = array(
			 'general'  => array(
				 'toggles' => array(
					 'main_content' => array(
						 'title' => esc_html__( 'Language Switcher', 'language-switcher-addon-for-divi' ),
					 ),
				 ),
			 ),
			 'advanced' => array(
				 'toggles' => array(
					 'lsad_flag_settings'       => array(
						 'title' => esc_html__( 'Flag', 'language-switcher-addon-for-divi' ),
					 ),
					 'lsad_text_settings'       => array(
						 'title' => esc_html__( 'Text', 'language-switcher-addon-for-divi' ),
					 ),
					 'lsad_background'          => array(
						 'title' => esc_html__( 'Background', 'language-switcher-addon-for-divi' ),
					 ),
					 'lsad_dropdown_background' => array(
						 'title' => esc_html__( 'Dropwdown Background', 'language-switcher-addon-for-divi' ),
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
		$advanced_fields['filter']         = false;
		$advanced_fields['box_shadow']     = false;
		$advanced_fields['border']     = false;

		$advanced_fields['fonts']['lsad_text_settings'] = array(
			'label_prefix'        => esc_html__( 'Text', 'language-switcher-addon-for-divi' ),
			'tab_slug'            => 'advanced',
			'toggle_slug'         => 'lsad_text_settings',
			'css'          => array(
				'main'      => '%%order_class%% .lsad-wrapper ul li.lsad_active_lang .lsad-lang-name, %%order_class%% .lsad-wrapper ul li.lsad_active_lang .lsad-lang-code, %%order_class%% .lsad-wrapper ul li:hover.lsad_active_lang .lsad-lang-name, %%order_class%% .lsad-wrapper ul li:hover.lsad_active_lang .lsad-lang-code, %%order_class%% .lsad-wrapper ul li .lsad-lang-name, %%order_class%% .lsad-wrapper ul li .lsad-lang-code, %%order_class%% .lsad-wrapper.dropdown span .lsad-lang-name a, %%order_class%% .lsad-wrapper.dropdown span .lsad-lang-code a, %%order_class%% .lsad-wrapper ul li a',
				'important' => 'all',
			),
			'hide_text_align'     => true,
		);

		// Configure the margin and padding for the container.
		$advanced_fields['margin_padding'] = array(
			'css'          => array(
				'main'      => '%%order_class%% .lsad-wrapper ul li, %%order_class%% .lsad-wrapper.dropdown',
				'important' => true,
			),
			'toggle_slug'  => 'lsad_background',
			'tab_slug'     => 'advanced',
		);

		return $advanced_fields;
	}

	public function get_fields() {
		return array(
			'lsad_style'                         => array(
				'label'       => esc_html__( 'Layout Options', 'language-switcher-addon-for-divi' ),
				'type'        => 'select',
				'default'     => 'horizontal',
				'options'     => array(
					'vertical'   => esc_html__( 'Vertical', 'language-switcher-addon-for-divi' ),
					'horizontal' => esc_html__( 'Horizontal', 'language-switcher-addon-for-divi' ),
					'dropdown'   => esc_html__( 'Dropdown', 'language-switcher-addon-for-divi' ),
				),
				'toggle_slug' => 'main_content',
			),
			'lsad_flag_visibility'               => array(
				'label'       => esc_html__( 'Display Flag', 'language-switcher-addon-for-divi' ),
				'type'        => 'yes_no_button',
				'default'     => 'on',
				'options'     => array('on','off'),
				'toggle_slug' => 'main_content'
			),
			'lsad_language_name_visibility'      => array(
				'label'       => esc_html__( 'Show Language Name', 'language-switcher-addon-for-divi' ),
				'type'        => 'yes_no_button',
				'options'     => array('on','off'),
				'default'     => 'on',
				'toggle_slug' => 'main_content'
			),
			'lsad_language_code_visibility'      => array(
				'label'       => esc_html__( 'Show Language Code', 'language-switcher-addon-for-divi' ),
				'type'        => 'yes_no_button',
				'options'     => array('on','off'),
				'toggle_slug' => 'main_content'
			),
			'lsad_current_lang_visibility'       => array(
				'label'       => esc_html__( 'Hide Current Language', 'language-switcher-addon-for-divi' ),
				'type'        => 'yes_no_button',
				'options'     => array('on','off'),
				'toggle_slug' => 'main_content',
				'show_if'     => array(
					'lsad_style' => array( 'horizontal', 'vertical' ),
				),
			),
			'lsad_unstranslated_lang_visibility' => array(
				'label'       => esc_html__( 'Hide Untranslated Languages', 'language-switcher-addon-for-divi' ),
				'type'        => 'yes_no_button',
				'options'     => array('on','off'),
				'toggle_slug' => 'main_content'
			),
			'lsad_flag_ratio'                    => array(
				'label'       => esc_html__( 'Aspect Ratio', 'language-switcher-addon-for-divi' ),
				'type'        => 'select',
				'default'     => 'horizontal',
				'options'     => array(
					'auto' => esc_html__( 'auto', 'language-switcher-addon-for-divi' ),
					'1/1'  => esc_html__( '1:1', 'language-switcher-addon-for-divi' ),
					'4/3'  => esc_html__( '4:3', 'language-switcher-addon-for-divi' ),
				),
				'toggle_slug' => 'lsad_flag_settings',
				'tab_slug'    => 'advanced'
			),
			'lsad_flag_width'                    => array(
				'label'          => esc_html__( 'Flag Width', 'language-switcher-addon-for-divi' ),
				'type'           => 'range',
				'default'        => '20px',
				'range_settings' => array(
					'min'  => '10px',
					'max'  => '100px',
					'step' => '1px',
				),
				'toggle_slug'    => 'lsad_flag_settings',
				'tab_slug'       => 'advanced'
			),
			'lsad_flag_radius'                   => array(
				'label'          => esc_html__( 'Flag Border Radius', 'language-switcher-addon-for-divi' ),
				'type'           => 'range',
				'default'        => '0px',
				'range_settings' => array(
					'min'  => '0px',
					'max'  => '100px',
					'step' => '1px',
				),
				'toggle_slug'    => 'lsad_flag_settings',
				'tab_slug'       => 'advanced'
			),

			'lsad_background_setting'            => array(
				'label'               => esc_html__( 'Background', 'language-switcher-addon-for-divi' ),
				'tab_slug'            => 'advanced',
				'toggle_slug'         => 'lsad_background',
				'attr_suffix'         => '',
				'type'                => 'composite',
				'composite_type'      => 'default',
				'composite_structure' => array(
					'lsad_background_normal' => array(
						'label'    => esc_html__( 'Normal', 'language-switcher-addon-for-divi' ),
						'controls' => array(
							'lsad_bg_normal_color' => array(
								'label' => esc_html__( 'Background Color', 'language-switcher-addon-for-divi' ),
								'type'  => 'color',
							),
						),
					),
					'lsad_background_hover'  => array(
						'label'    => esc_html__( 'Hover', 'language-switcher-addon-for-divi' ),
						'controls' => array(
							'lsad_bg_hover_color' => array(
								'label' => esc_html__( 'Background Color', 'language-switcher-addon-for-divi' ),
								'type'  => 'color',
							),
						),
					),
				),
			),
		);
	}

	public function render( $attrs, $content = null, $render_slug = null ) {
			$static_style_loader = new LSAD_STYLE_HELPERS( $attrs, $render_slug, self::$language_index );
			self::$language_index++;
			$style                 = ! isset( $attrs['lsad_style'] ) ? 'horizontal' : $attrs['lsad_style'];
			$flag_display          = ! isset( $attrs['lsad_flag_visibility'] ) ? 'on' : $attrs['lsad_flag_visibility'];
			$name_display          = ! isset( $attrs['lsad_language_name_visibility'] ) ? 'on' : $attrs['lsad_language_name_visibility'];
			$code_display          = ! isset( $attrs['lsad_language_code_visibility'] ) ? 'off' : $attrs['lsad_language_code_visibility'];
			$hide_current_lang     = ! isset( $attrs['lsad_current_lang_visibility'] ) ? 'off' : $attrs['lsad_current_lang_visibility'];
			$hide_untranslate_lang = ! isset( $attrs['lsad_unstranslated_lang_visibility'] ) ? 'off' : $attrs['lsad_unstranslated_lang_visibility'];
			$display_content       = in_array( 'on', array( $flag_display, $name_display, $code_display ) ) || in_array( 'off', array( $hide_current_lang, $hide_untranslate_lang ) );

			if ( $display_content ) {

				$languages = pll_the_languages( array( 'raw' => 1 ) );
				$lang_curr = strtolower( pll_current_language() );

				$html        = '';
				$active_span = '';

				if ( $style === 'dropdown' ) {
					$active_flag_icon = LSAD_HELPERS::get_country_flag( $languages[ $lang_curr ]['flag'], $languages[ $lang_curr ]['name'] );
					$active_span      = '<span>';
					if ( 'on' === $flag_display ) {
						$active_span .= sprintf(
							'<div class="lsad-lang-image">%s</div>',
							$active_flag_icon,
							esc_url( $languages[ $lang_curr ]['flag'] )
						);
					}

					if ( 'on' === $name_display ) {
						$active_span .= sprintf(
							'<div class="lsad-lang-name"><a href="%s">%s</a></div>',
							esc_url( $languages[ $lang_curr ]['url'] ),
							esc_html( $languages[ $lang_curr ]['name'] )
						);
					}

					if ( 'on' === $code_display ) {
						$active_span .= sprintf(
							'<div class="lsad-lang-code"><a href="%s">%s</a></div>',
							esc_url( $languages[ $lang_curr ]['url'] ),
							esc_html( $languages[ $lang_curr ]['slug'] )
						);
					}
					$active_span .= '</span>';
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
					$flag_icon    = LSAD_HELPERS::get_country_flag( $lang['flag'], $lang['name'] );
					$anchor_open  = $lang_curr === $lang['slug'] ? '' : '<a href="' . esc_url( $lang['url'] ) . '">';
					$anchor_close = $lang_curr === $lang['slug'] ? '' : '</a>';
					$active_class = $lang_curr === $lang['slug'] ? 'lsad_active_lang' : '';
					$html        .= '<li class="' . esc_attr( $active_class ) . '">';

					if ( 'on' === $flag_display ) {
						$html .= sprintf(
							'<div class="lsad-lang-image">%s%s%s</div>',
							wp_kses_post( $anchor_open ),
							$flag_icon,
							wp_kses_post( $anchor_close )
						);
					}

					if ( 'on' === $name_display ) {
						$html .= sprintf(
							'<div class="lsad-lang-name">%s%s%s</div>',
							wp_kses_post( $anchor_open ),
							esc_html( $lang['name'] ),
							wp_kses_post( $anchor_close ),
						);
					}

					if ( 'on' === $code_display ) {
						$html .= sprintf(
							'<div class="lsad-lang-code">%s%s%s</div>',
							wp_kses_post( $anchor_open ),
							esc_html( $lang['slug'] ),
							wp_kses_post( $anchor_close ),
						);
					}

					$html .= '</li>';
				}

				$output = sprintf(
					' <div id="lsad-wrapper" class="lsad-wrapper %1$s">
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

new LSAD_Module();
