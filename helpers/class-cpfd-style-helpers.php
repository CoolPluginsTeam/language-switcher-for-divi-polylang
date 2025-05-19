<?php

if ( ! defined( 'ABSPATH' ) ) {
  die( 'Direct access forbidden.' );
}
class CPFD_STYLE_HELPERS {
	private $redner_slug = '';
	private $props       = '';
	private $order       = 0;

	public function __construct( $props, $render_slug, $order ) {
		$this->redner_slug = $render_slug;
		$this->props       = $props;
		$this->order       = $order;
		$this->generate_divi_styles();
	} 

	private function generate_divi_styles() {
		$selector = '%%order_class%% .cpfd-wrapper';
		$slug                    = $this->redner_slug;
		$attr                    = $this->props;
		$lang_padding            = isset( $attr['cpfd_bg_normal_padding'] ) ? esc_attr($attr['cpfd_bg_normal_padding']) : '';
		$lang_margin             = isset( $attr['cpfd_bg_normal_margin'] ) ? esc_attr($attr['cpfd_bg_normal_margin']) : '';
		$lang_normal_bg_color    = isset( $attr['cpfd_bg_normal_color'] ) ? esc_attr($attr['cpfd_bg_normal_color']) : '';
		$lang_hover_bg_color_hover = isset( $attr['cpfd_bg_normal_color__hover'] ) ? esc_attr($attr['cpfd_bg_normal_color__hover']) : '';
		$flag_width              = isset( $attr['cpfd_flag_width'] ) ? esc_attr($attr['cpfd_flag_width']) : '';
		$flag_radius             = isset( $attr['cpfd_flag_radius'] ) ? esc_attr($attr['cpfd_flag_radius']) : '';
		$flag_ratio              = isset( $attr['cpfd_flag_ratio'] ) ? esc_attr($attr['cpfd_flag_ratio']) : '';
		$normal_text_font        = isset( $attr['cpfd_text_settings_font'] ) ? esc_attr($attr['cpfd_text_settings_font']) : '';
		$hover_text_font         = isset( $attr['cpfd_text_settings_font__hover'] ) ? esc_attr($attr['cpfd_text_settings_font__hover']) : '';
		$normal_text_color       = isset( $attr['cpfd_text_settings_text_color'] ) ? esc_attr($attr['cpfd_text_settings_text_color']) : '';
		$hover_text_color 		 = isset( $attr['cpfd_text_settings_text_color__hover'] ) ? esc_attr($attr['cpfd_text_settings_text_color__hover']) : '';
		$normal_text_size        = isset( $attr['cpfd_text_settings_font_size'] ) ? esc_attr($attr['cpfd_text_settings_font_size']) : '';
		$hover_text_size		 = isset( $attr['cpfd_text_settings_font_size__hover'] ) ? esc_attr($attr['cpfd_text_settings_font_size__hover']) : '';
		$normal_text_spacing     = isset( $attr['cpfd_text_settings_letter_spacing'] ) ? esc_attr($attr['cpfd_text_settings_letter_spacing']) : '';
		$hover_text_spacing      = isset( $attr['cpfd_text_settings_letter_spacing__hover'] ) ? esc_attr($attr['cpfd_text_settings_letter_spacing__hover']) : '';
		$normal_text_line_height = isset( $attr['cpfd_text_settings_line_height'] ) ? esc_attr($attr['cpfd_text_settings_line_height']) : '';
		$hover_text_line_height  = isset( $attr['cpfd_text_settings_line_height__hover'] ) ? esc_attr($attr['cpfd_text_settings_line_height__hover']) : '';
		$hover_bg_margin         = isset( $attr['custom_margin__hover'] ) ? esc_attr($attr['custom_margin__hover']) : '';
		$hover_bg_padding        = isset( $attr['custom_padding__hover'] ) ? esc_attr($attr['custom_padding__hover']) : '';
		ET_Builder_Element::set_style(
			$slug,
			array(
				'selector'    => $selector.'.dropdown',
				'declaration' => sprintf( '--cpfd-dropdown-index: %1$s;', ( 999 + $this->order ) ),
			)
		);

		if ( '' !== $lang_padding ) {
			$padding = $this->get_unit_value( $lang_padding );

			foreach ( $padding as $key => $value ) {
				if ( ! empty( $value ) ) {
					ET_Builder_Element::set_style(
						$slug,
						array(
							'selector'    => $selector,
							'declaration' => sprintf( '--cpfd-lang-padding-%1$s: %2$s;', $key, $value ),
						)
					);
				}
			}
		}
		if ( '' !== $lang_margin ) {
			$margin = $this->get_unit_value( $lang_margin );
			foreach ( $margin as $key => $value ) {
				if ( ! empty( $value ) ) {
					ET_Builder_Element::set_style(
						$slug,
						array(
							'selector'    => $selector,
							'declaration' => sprintf( '--cpfd-lang-margin-%1$s: %2$s;', $key, $value ),
						)
					);
				}
			}
		}

		if ( '' !== $lang_normal_bg_color ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--cpfd-normal-bg-color: %1$s;', $lang_normal_bg_color ),
				)
			);
		}
		if ( '' !== $lang_hover_bg_color_hover ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--cpfd-hover-bg-color: %1$s;', $lang_hover_bg_color_hover ),
				)
			);
		}

		if ( '' !== $hover_bg_margin ) {
			$margin = $this->get_unit_value( $hover_bg_margin );
			foreach ( $margin as $key => $value ) {
				if ( ! empty( $value ) ) {
					ET_Builder_Element::set_style(
						$slug,
						array(
							'selector'    => $selector,
							'declaration' => sprintf( '--cpfd-hover-bg-mrgn-%1$s: %2$s;', $key, $value ),
						)
					);
				}
			}
		}
		if ( '' !== $hover_bg_padding ) {
			$padding = $this->get_unit_value( $hover_bg_padding );
			foreach ( $padding as $key => $value ) {
				if ( ! empty( $value ) ) {
					ET_Builder_Element::set_style(
						$slug,
						array(
							'selector'    => $selector,
							'declaration' => sprintf( '--cpfd-hover-bg-pading-%1$s: %2$s;', $key, $value ),
						)
					);
				}
			}
		}

		if ( '' !== $flag_ratio && '1/1' === $flag_ratio ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => '--cpfd-flag-height: var(--cpfd-flag-width);',
				)
			);
		}
		if ( '' !== $flag_width ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--cpfd-flag-width: %1$s;', $flag_width ),
				)
			);
		}
		if ( '' !== $flag_radius ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--cpfd-flag-radius: %1$s;', $flag_radius ),
				)
			);
		}
		if ( '' !== $normal_text_font ) {
			$this->load_google_fonts( $normal_text_font );
			$Font_properties = $this->get_font_properties( $normal_text_font );
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--cpfd-normal-text-font: %1$s;', $Font_properties['fontFamily'] ),
				)
			);
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--cpfd-normal-text-weight: %1$s;', $Font_properties['fontWeight'] ),
				)
			);
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--cpfd-normal-text-transform: %1$s;', $Font_properties['textTransform'] ),
				)
			);
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--cpfd-normal-text-decoration: %1$s;', $Font_properties['textDecoration'] ),
				)
			);
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--cpfd-normal-text-style: %1$s;', $Font_properties['fontStyle'] ),
				)
			);
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--cpfd-normal-text-decoration-color: %1$s;', $Font_properties['textDecorationLineColor'] ),
				)
			);
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--cpfd-normal-text-decoration-style: %1$s;', $Font_properties['textDecorationStyle'] ),
				)
			);
		}
		if ( '' !== $normal_text_color ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--cpfd-normal-text-color: %1$s;', $normal_text_color ),
				)
			);
		}
		if ( '' !== $hover_text_color ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--cpfd-hover-text-color: %1$s;', $hover_text_color ),
				)
			);
		}
		if ( '' !== $normal_text_spacing ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--cpfd-normal-text-letter-spacing: %1$s;', $normal_text_spacing ),
				)
			);
		}
		if ( '' !== $hover_text_spacing ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--cpfd-hover-text-letter-spacing: %1$s;', $hover_text_spacing ),
				)
			);
		}
		if ( '' !== $normal_text_size ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--cpfd-normal-text-size: %1$s;', $normal_text_size ),
				)
			);
		}
		if( '' !== $hover_text_size){
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--cpfd-hover-text-size: %1$s;', $hover_text_size ),
				)
			);
		}
		if ( '' !== $normal_text_line_height ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--cpfd-normal-text-line-height: %1$s;', $normal_text_line_height ),
				)
			);
		}
		if ( '' !== $hover_text_line_height ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--cpfd-hover-text-line-height: %1$s;', $hover_text_line_height ),
				)
			);
		}
		// Code for generating Divi styles goes here
	}

	private function load_google_fonts( $font_family ) {
		$font_parts       = explode( '|', $font_family );
		$font_family_name = $font_parts[0];
		if ( $font_family_name ) {
			wp_enqueue_style( 'cpfd-gfonts-' . $font_family_name, "https://fonts.googleapis.com/css2?family=$font_family_name&display=swap", [], CPFD );
		}
	}

	private function get_font_properties( $fontString ) {
		$fontParts  = explode( '|', $fontString );
		$fontFamily = $fontParts[0];
		$fontWeight = $fontParts[1];
		$fontStyle  = ! empty( $fontParts[2] ) ? 'italic' : 'normal';
		// Determine text transform
		if ( ! empty( $fontParts[3] ) ) {
			$textTransform = 'uppercase';
		} elseif ( ! empty( $fontParts[5] ) ) {
			$textTransform = 'capitalize';
		} else {
			$textTransform = 'none';
		}

		// Determine text decoration
		if ( ! empty( $fontParts[4] ) && ! empty( $fontParts[6] ) ) {
			$textDecoration = 'line-through';
		} elseif ( ! empty( $fontParts[4] ) ) {
			$textDecoration = 'underline';
		} elseif ( ! empty( $fontParts[6] ) ) {
			$textDecoration = 'line-through';
		} else {
			$textDecoration = 'none';
		}

		$textDecorationLineColor = ( ! empty( $fontParts[7] ) ) ? $fontParts[7] : '';
		$textDecorationStyle     = ( ! empty( $fontParts[8] ) ) ? $fontParts[8] : '';

		return array(
			'fontFamily'              => $fontFamily,
			'fontWeight'              => $fontWeight,
			'fontStyle'               => $fontStyle,
			'textTransform'           => $textTransform,
			'textDecoration'          => $textDecoration,
			'textDecorationLineColor' => $textDecorationLineColor,
			'textDecorationStyle'     => $textDecorationStyle,
		);
	}

	private function get_unit_value( $unitString ) {
		$units = explode( '|', $unitString );

		return array(
			'top'    => $units[0],
			'bottom' => $units[2],
			'left'   => $units[3],
			'right'  => $units[1],
		);
	}
}
