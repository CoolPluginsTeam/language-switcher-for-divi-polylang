<?php

class LSAD_STYLE_HELPERS {
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
		$selector = '%%order_class%% .lsad-wrapper';

		$slug                    = $this->redner_slug;
		$attr                    = $this->props;
		$lang_padding            = isset( $attr['lsad_bg_normal_padding'] ) ? $attr['lsad_bg_normal_padding'] : '';
		$lang_margin             = isset( $attr['lsad_bg_normal_margin'] ) ? $attr['lsad_bg_normal_margin'] : '';
		$lang_normal_bg_color    = isset( $attr['lsad_bg_normal_color'] ) ? $attr['lsad_bg_normal_color'] : '';
		$lang_hover_bg_color     = isset( $attr['lsad_bg_hover_color'] ) ? $attr['lsad_bg_hover_color'] : '';
		$flag_width              = isset( $attr['lsad_flag_width'] ) ? $attr['lsad_flag_width'] : '';
		$flag_radius             = isset( $attr['lsad_flag_radius'] ) ? $attr['lsad_flag_radius'] : '';
		$flag_ratio              = isset( $attr['lsad_flag_ratio'] ) ? $attr['lsad_flag_ratio'] : '';
		$normal_text_font        = isset( $attr['lsad_text_settings_font'] ) ? $attr['lsad_text_settings_font'] : '';
		$normal_text_color       = isset( $attr['lsad_text_settings_text_color'] ) ? $attr['lsad_text_settings_text_color'] : '';
		$normal_text_size        = isset( $attr['lsad_text_settings_font_size'] ) ? $attr['lsad_text_settings_font_size'] : '';
		$normal_text_spacing     = isset( $attr['lsad_text_settings_letter_spacing'] ) ? $attr['lsad_text_settings_letter_spacing'] : '';
		$normal_text_line_height = isset( $attr['lsad_text_settings_line_height'] ) ? $attr['lsad_text_settings_line_height'] : '';
		$hover_text_font         = isset( $attr['lsad_hover_text_font'] ) ? $attr['lsad_hover_text_font'] : '';
		$hover_text_color        = isset( $attr['lsad_hover_text_color'] ) ? $attr['lsad_hover_text_color'] : '';
		$hover_text_size         = isset( $attr['lsad_hover_text_font_size'] ) ? $attr['lsad_hover_text_font_size'] : '';
		$hover_text_line_height  = isset( $attr['lsad_hover_text_line_height'] ) ? $attr['lsad_hover_text_line_height'] : '';
		ET_Builder_Element::set_style(
			$slug,
			array(
				'selector'    => $selector.'.dropdown',
				'declaration' => sprintf( '--lsad-dropdown-index: %1$s;', ( 99 + $this->order ) ),
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
							'declaration' => sprintf( '--lsad-lang-padding-%1$s: %2$s;', $key, $value ),
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
							'declaration' => sprintf( '--lsad-lang-padding-%1$s: %2$s;', $key, $value ),
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
					'declaration' => sprintf( '--lsad-normal-bg-color: %1$s;', $lang_normal_bg_color ),
				)
			);
		}

		if ( '' !== $lang_hover_bg_color ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-hover-bg-color: %1$s;', $lang_hover_bg_color ),
				)
			);
		}

		if ( '' !== $flag_ratio && '1/1' === $flag_ratio ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => '--lsad-flag-height: var(--lsad-flag-width);',
				)
			);
		}
		if ( '' !== $flag_width ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-flag-width: %1$s;', $flag_width ),
				)
			);
		}
		if ( '' !== $flag_radius ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-flag-radius: %1$s;', $flag_radius ),
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
					'declaration' => sprintf( '--lsad-normal-text-font: %1$s;', $Font_properties['fontFamily'] ),
				)
			);
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-normal-text-weight: %1$s;', $Font_properties['fontWeight'] ),
				)
			);
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-normal-text-transform: %1$s;', $Font_properties['textTransform'] ),
				)
			);
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-normal-text-decoration: %1$s;', $Font_properties['textDecoration'] ),
				)
			);
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-normal-text-style: %1$s;', $Font_properties['fontStyle'] ),
				)
			);
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-normal-text-decoration-color: %1$s;', $Font_properties['textDecorationLineColor'] ),
				)
			);
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-normal-text-decoration-style: %1$s;', $Font_properties['textDecorationStyle'] ),
				)
			);
		}
		if ( '' !== $normal_text_color ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-normal-text-color: %1$s;', $normal_text_color ),
				)
			);
		}
		if ( '' !== $normal_text_spacing ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-normal-text-letter-spacing: %1$s;', $normal_text_spacing ),
				)
			);
		}
		if ( '' !== $normal_text_size ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-normal-text-size: %1$s;', $normal_text_size ),
				)
			);
		}
		if ( '' !== $normal_text_line_height ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-normal-text-line-height: %1$s;', $normal_text_line_height ),
				)
			);
		}
		if ( '' !== $hover_text_font ) {
			$this->load_google_fonts( $hover_text_font );
			$Font_properties = $this->get_font_properties( $hover_text_font );
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-hover-text-font: %1$s;', $Font_properties['fontFamily'] ),
				)
			);
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-hover-text-weight: %1$s;', $Font_properties['fontWeight'] ),
				)
			);
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-hover-text-transform: %1$s;', $Font_properties['textTransform'] ),
				)
			);
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-hover-text-decoration: %1$s;', $Font_properties['textDecoration'] ),
				)
			);
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-hover-text-style: %1$s;', $Font_properties['fontStyle'] ),
				)
			);
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-hover-text-decoration-color: %1$s;', $Font_properties['textDecorationLineColor'] ),
				)
			);
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-hover-text-decoration-style: %1$s;', $Font_properties['textDecorationStyle'] ),
				)
			);
		}
		if ( '' !== $hover_text_color ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-hover-text-color: %1$s;', $hover_text_color ),
				)
			);
		}
		if ( '' !== $hover_text_size ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-hover-text-size: %1$s;', $hover_text_size ),
				)
			);
		}
		if ( '' !== $hover_text_line_height ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--lsad-hover-text-line-height: %1$s;', $hover_text_line_height ),
				)
			);
		}
		// Code for generating Divi styles goes here
	}

	private function load_google_fonts( $font_family ) {
		$font_parts       = explode( '|', $font_family );
		$font_family_name = $font_parts[0];
		if ( $font_family_name ) {
			wp_enqueue_style( 'lsad-gfonts-' . $font_family_name, "https://fonts.googleapis.com/css2?family=$font_family_name&display=swap", array(), null );
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
		} elseif ( ! empty( $fontParts[4] ) ) {
			$textTransform = 'capitalize';
		} else {
			$textTransform = 'none';
		}

		// Determine text decoration
		if ( ! empty( $fontParts[5] ) && ! empty( $fontParts[6] ) ) {
			$textDecoration = 'line-through';
		} elseif ( ! empty( $fontParts[5] ) ) {
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
