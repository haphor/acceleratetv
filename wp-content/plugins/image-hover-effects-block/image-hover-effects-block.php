<?php
/**
 * Plugin Name: 	  Image Hover Effects Block
 * Plugin URI:  	  https://imagehoverblock.blocksera.com/
 * Author: 			  Blocksera
 * Author URI:		  https://blocksera.com
 * Description: 	  Collection of image hover effects for WordPress Block editor Gutenberg.
 * Version:     	  1.2.0
 * Requires at least: 5.0
 * Tested up to:      5.3.2
 * License: 		  GPL v3
 * Text Domain:		  iheg-lang
 * Domain Path: 	  /languages
**/

if (!defined('ABSPATH')) {
    exit;
}

define('IHEG_VERSION', 	'1.2.0');
define('IHEG_PATH', 	plugin_dir_path(__FILE__));
define("IHEG_URL", 		plugin_dir_url(__FILE__));


class ImageHoverEffectsBlock {

	public function activate() {}
	
	public function deactivate() {}

	public function __construct() {
        register_activation_hook(__FILE__, 		array($this, 'activate'));
        register_deactivation_hook(__FILE__, 	array($this, 'deactivate'));
		$this->init_hooks();
	}


	public function init_hooks() {
		add_action( 'init', 						array($this, 'imagehoverplugin'));
		add_action( 'enqueue_block_editor_assets', 	array($this, 'add_custom_script'));
		
		$iheg_version = get_transient('iheg_version');
        if (version_compare($iheg_version, IHEG_VERSION, '<')) {
            delete_transient('iheg_webfonts');
            set_transient('iheg_version', IHEG_VERSION);
        }
	}

	public function add_custom_script() {
		wp_enqueue_script( 'iheg-editor-js' );
	}

	public function imagehoverplugin() {
		
		wp_register_style('iheg-editor-css',			IHEG_URL . 'src/blocks/css/editor-css.css', array(), IHEG_VERSION, 'all');
		wp_register_script('iheg-editor-js',			IHEG_URL . 'src/blocks/js/editor-script.js', array("jquery"),IHEG_VERSION, '');
		wp_register_script('iheg-build',				IHEG_URL . 'build/index.js', array('wp-blocks','wp-editor'),IHEG_VERSION, true);

		wp_enqueue_style('fonticonpicker-base',			IHEG_URL . 'src/blocks/css/fonticonpicker.base-theme.react.css', array(), IHEG_VERSION, 'all');
		wp_enqueue_style('fonticonpicker-material',		IHEG_URL . 'src/blocks/css/fonticonpicker.material-theme.react.css', array(), IHEG_VERSION, 'all');
		wp_enqueue_style('fontawesome-all',				IHEG_URL . '/assets/fontawesome-v5/css/all.min.css', array(), IHEG_VERSION, 'all');
		wp_enqueue_style('iheg-css',					IHEG_URL . 'assets/css/style.css', array(), IHEG_VERSION, 'all');

		if(is_admin()){
			
			$webfonts = get_transient('iheg_webfonts');
			if($webfonts === false) {
                $request = wp_remote_get(IHEG_URL.'assets/webfonts.json');
                $response = wp_remote_retrieve_body($request);
                $webfonts = json_decode($response, true);
				set_transient('iheg_webfonts', $webfonts);
			}
			
			$data['webfonts']	= $webfonts;
			wp_localize_script('iheg-build', 'IHEG', $data);
		}
		wp_enqueue_script('iheg-build');
		
		register_block_type('block/image-hover-effects-block',
		array(
			'attributes'	=>	array(
				'widget_title' => array(
					'type' => 'string',
					'default' => 'Title',
				),
				'widget_description' => array(
					'type' => 'string',
					'default' => 'Description',
				),
				'hover_effect' => array(
					'type' => 'string',
					'default' => 'eihe-fade',
				),
				'linktourl' => array(
					'type' => 'string',
					'default' => ''
				),
				'addtarget' => array(
					'type' => 'boolean',
					'default' => false
				),
				'addrel' => array(
					'type' => 'boolean',
					'default' => false
				),
				'img_size' => array(
					'type' => 'string',
					'default' => 'full'
				),
				'imgid' => array(
					'type' =>'number',
					'default' => ''
				),
				'imgurl' => array(
					'type' =>'string',
					'default' => '',
				),
				'img_size_id'=> array(
					'type' => 'array',
					'items' => [
						'type' => 'array',
					],
					'default'=> [
						array( "label" => "Thumbnail - (150 x 150)", "value" => "thumbnail" ),
						array( "label" => "Medium - (300 x 200)", "value" => "medium" ),
						array( "label" => "Full - (1920 x 1280)", "value" => "full" ),
					],
				),					
				'img_size_default'=> array(
					'type' => 'array',
					'items' => [
						'type' => 'array',
					],
					'default'=> [
						array( 
								"thumbnail"	=> "". IHEG_URL ."assets/img/desert-150x150.jpg",
								"medium"	=> "". IHEG_URL ."assets/img/desert-300x200.jpg",
								"full"		=> "". IHEG_URL ."assets/img/desert.jpg" 
							),
					],
				),
				'overlay_color' => array(
					'type' => 'string',
					'default' => '#000',
				),
				'title_tag' => array(
					'type' => 'string',
					'default' => 'h3',
				),
				'title_color' => array(
					'type' => 'string',
					'default' => '#fff',
				),
				'title_font' => array(
					'type' => 'string',
					'default' => 'inherit',
				),
				'title_font_subset' => array(
					'type' => 'string',
					'default' => 'latin',
				),
				'title_font_size' => array(
					'type' => 'number',
					'default' => 40,
				),
				'title_font_weight' => array(
					'type' => 'number',
					'default' => 400,
				),
				'title_font_transform' => array(
					'type' => 'string',
					'default' => 'none',
				),
				'title_font_style' => array(
					'type' => 'string',
					'default' => 'normal',
				),
				'title_font_decoration' => array(
					'type' => 'string',
					'default' => 'none',
				),
				'title_line_height' => array(
					'type' => 'number',
					'default' => 40,
				),
				'title_letter_spacing' => array(
					'type' => 'number',
					'default' => 0,
				),
				'title_style' => array(
					'source' => 'attribute',
					'attribute' => 'style',
				),
				'desc_color' => array(
					'type' => 'string',
					'default' => '#fff',
				),
				'desc_font' => array(
					'type' => 'string',
					'default' => 'inherit',
				),
				'desc_font_subset' => array(
					'type' => 'string',
					'default' => 'latin',
				),
				'desc_font_size' => array(
					'type' => 'number',
					'default' => 20,
				),
				'desc_font_weight' => array(
					'type' => 'number',
					'default' => 400,
				),
				'desc_font_transform' => array(
					'type' => 'string',
					'default' => 'none',
				),
				'desc_font_style' => array(
					'type' => 'string',
					'default' => 'normal',
				),
				'desc_font_decoration' => array(
					'type' => 'string',
					'default' => 'none',
				),
				'desc_line_height' => array(
					'type' => 'number',
					'default' => 20,
				),
				'desc_letter_spacing' => array(
					'type' => 'number',
					'default' => 0,
				),
				'desc_style' => array(
					'source' => 'attribute',
					'attribute' => 'style',
				),
				'icon' => array(
					'type' => 'string',
					'default' => ''
				),
				'icon_position' => array(
					'type' => 'number',
					'default' => 0,
				),
				'icon_color' => array(
					'type' => 'string',
					'default' => '#ddd'
				),
				'icon_size' => array(
					'type' => 'number',
					'default' => 30,
				),
				'icon_space' => array(
					'type' => 'number',
					'default' => 15,
				),
				'icon_margin_left' => array(
					'type' => 'number',
					'default' => 15,
				),
				'icon_margin_right' => array(
					'type' => 'number',
					'default' => 0,
				),
				'icon_display' => array(
					'type' => 'string',
					'default' => 'none'
				),
				'icon_style' => array(
					'source' => 'attribute',
					'attribute' => 'style',
				),
				'horizontal_flexalignment' => array(
					'type' => 'string',
					'default' => 'center',
				),
				'vertical_flexalignment' => array(
					'type' => 'string',
					'default' => 'center',
				),
				'padding_unit' => array(
					'type' => 'string',
					'default' => 'px',
				),
				'padding_check' => array(
					'type' => 'boolean',
					'default' => true
				),
				'padding_top' => array(
					'type' =>'string',
					'default' => '30',
				),
				'padding_right' => array(
					'type' =>'string',
					'default' => '30',
				),
				'padding_bottom' => array(
					'type' =>'string',
					'default' => '30',
				),
				'padding_left' => array(
					'type' =>'string',
					'default' => '30',
				),
				'border_radius_unit' => array(
					'type' => 'string',
					'default' => 'px',
				),
				'border_radius_check' => array(
					'type' => 'boolean',
					'default' => true
				),
				'border_radius_top_left' => array(
					'type' =>'string',
					'default' => '',
				),
				'border_radius_top_right' => array(
					'type' =>'string',
					'default' => '',
				),
				'border_radius_bottom_left' => array(
					'type' =>'string',
					'default' => '',
				),
				'border_radius_bottom_right' => array(
					'type' =>'string',
					'default' => '',
				),
				'horizontal_btn' => array(
					'type' => 'string',
					'default' => 'center',
				),
				'box_style' => array(
					'source' => 'attribute',
					'attribute' => 'style',
				),
				'caption_style' => array(
					'source' => 'attribute',
					'attribute' => 'style',
				),
			),
			'editor_style' 		=> 'iheg-editor-css',
			'editor_js' 		=> 'iheg-editor-js',
			'render_callback' 	=> array($this, 'iheg_render_callback'),
		));
		
	}

	public function iheg_render_callback($attributes){

		//sanitize here
		$attributes['imgid'] 						= intval( $attributes['imgid'] );
		$attributes['img_size'] 					= esc_attr( $attributes['img_size'] );
		
		$attributes['widget_title'] 				= wp_kses_post($attributes['widget_title']);
		$attributes['widget_description'] 			= wp_kses_post($attributes['widget_description']);
		
		$attributes['hover_effect'] 				= esc_attr( $attributes['hover_effect'] );
		$attributes['overlay_color'] 				= esc_attr( $attributes['overlay_color'] );
		$attributes['linktourl'] 					= esc_url( $attributes['linktourl'] );
		$attributes['addtarget'] 					= esc_attr( $attributes['addtarget'] );
		$attributes['addrel'] 						= esc_attr( $attributes['addrel'] );

		$attributes['title_tag'] 					= esc_attr( $attributes['title_tag'] );
		$attributes['title_font'] 					= esc_attr( $attributes['title_font'] );
		$attributes['title_color'] 					= esc_attr( $attributes['title_color'] );
		$attributes['title_font_size'] 				= intval( $attributes['title_font_size'] );
		$attributes['title_font_weight'] 			= esc_attr( $attributes['title_font_weight'] );
		$attributes['title_font_transform'] 		= esc_attr( $attributes['title_font_transform'] );
		$attributes['title_font_style'] 			= esc_attr( $attributes['title_font_style'] );
		$attributes['title_font_decoration']		= esc_attr( $attributes['title_font_decoration'] );
		$attributes['title_line_height'] 			= intval( $attributes['title_line_height'] );
		$attributes['title_letter_spacing'] 		= intval( $attributes['title_letter_spacing'] );

		$attributes['desc_font']  					= esc_attr( $attributes['desc_font'] );
		$attributes['desc_color'] 					= esc_attr( $attributes['desc_color'] );
		$attributes['desc_font_size'] 				= intval( $attributes['desc_font_size'] );
		$attributes['desc_font_weight'] 			= esc_attr( $attributes['desc_font_weight'] );
		$attributes['desc_font_transform'] 			= esc_attr( $attributes['desc_font_transform'] );
		$attributes['desc_font_style'] 				= esc_attr( $attributes['desc_font_style'] );
		$attributes['desc_font_decoration'] 		= esc_attr( $attributes['desc_font_decoration'] );
		$attributes['desc_line_height'] 			= intval( $attributes['desc_line_height'] );
		$attributes['desc_letter_spacing'] 			= intval( $attributes['desc_letter_spacing'] );

		$attributes['icon'] 						= esc_attr( $attributes['icon'] );
		$attributes['icon_position'] 				= esc_attr( $attributes['icon_position'] );
		$attributes['icon_display'] 				= esc_attr( $attributes['icon_display'] );
		$attributes['icon_color'] 					= esc_attr( $attributes['icon_color'] );
		$attributes['icon_size'] 					= intval( $attributes['icon_size'] );
		$attributes['icon_margin_left'] 			= intval( $attributes['icon_margin_left'] );
		$attributes['icon_margin_right'] 			= intval( $attributes['icon_margin_right'] );

		$attributes['horizontal_flexalignment'] 	= esc_attr( $attributes['horizontal_flexalignment'] );
		$attributes['vertical_flexalignment'] 		= esc_attr( $attributes['vertical_flexalignment'] );

		$attributes['border_radius_unit'] 			= esc_attr( $attributes['border_radius_unit'] );
		$attributes['border_radius_top_left'] 		= intval( $attributes['border_radius_top_left'] );
		$attributes['border_radius_top_right'] 		= intval( $attributes['border_radius_top_right'] );
		$attributes['border_radius_bottom_left'] 	= intval( $attributes['border_radius_bottom_left'] );
		$attributes['border_radius_bottom_right'] 	= intval( $attributes['border_radius_bottom_right'] );

		$attributes['padding_unit'] 				= esc_attr( $attributes['padding_unit'] );
		$attributes['padding_top'] 					= intval( $attributes['padding_top'] );
		$attributes['padding_right'] 				= intval( $attributes['padding_right'] );
		$attributes['padding_bottom'] 				= intval( $attributes['padding_bottom'] );
		$attributes['padding_left'] 				= intval( $attributes['padding_left'] );

		$webfonts = get_transient('iheg_webfonts');
        if($webfonts === false) {
            $request = wp_remote_get(IHEG_URL.'assets/webfonts.json');
            $response = wp_remote_retrieve_body($request);
            $webfonts = json_decode($response, true);
            set_transient('iheg_webfonts', $webfonts);
        }
        
        foreach($webfonts['items'] as $key => $font) {
            $id = trim(strtolower(str_replace(' ', '-', $font['family'])));
            $fonts[$id] = $font;
		}

		// Load font on Fronend...
		$font_handle = $attributes['title_font'];
		if($font_handle && $font_handle != 'inherit'){
			$font_family = esc_attr( str_replace( '+', ' ', $font_handle ));
			$font_handle = str_replace( ' ', '-', strtolower( $font_handle ));
			$variant     = $fonts[ $font_handle ]['variants'];
			$variants    = join( array_values( $variant ), ',' );
			wp_enqueue_style( 'iheg-google-font-' . $font_handle, 'https://fonts.googleapis.com/css?family=' . $font_family . ':' . $variants . '&display=swap', array(), IHEG_VERSION );
		}

		$font_handle = $attributes['desc_font'];
		if($font_handle && $font_handle != 'inherit'){
			$font_family = esc_attr( str_replace( '+', ' ', $font_handle ));
			$font_handle = str_replace( ' ', '-', strtolower( $font_handle ));
			$variant     = $fonts[ $font_handle ]['variants'];
			$variants    = join( array_values( $variant ), ',' );
			wp_enqueue_style( 'iheg-google-font-' . $font_handle, 'https://fonts.googleapis.com/css?family=' . $font_family . ':' . $variants . '&display=swap', array(), IHEG_VERSION );
		}

		if($attributes['imgid'] != '0'){
			$widgetimg =  wp_get_attachment_image_src($attributes['imgid'], $attributes['img_size'])[0];
		} else {
			$widgetimg = $attributes['img_size_default'][0][$attributes['img_size']];
		}

		//  Apply style attribute values...
		$title_style  = '';
		$title_style .= ($attributes['title_color'] != '#fff') ? "color: ". $attributes['title_color'] .";" : '';
		$title_style .= ($attributes['title_font'] != 'inherit') ? "font-family: ". $attributes['title_font'] .";" : '';
		$title_style .= ($attributes['title_font_size'] != '40') ? "font-size: ". $attributes['title_font_size'] ."px;" : '';
		$title_style .= ($attributes['title_font_weight'] != '400') ? "font-weight: ". $attributes['title_font_weight'] .";" : '';
		$title_style .= ($attributes['title_font_transform'] != 'none') ? "text-transform: ". $attributes['title_font_transform'] .";" : '';
		$title_style .= ($attributes['title_font_style'] != 'normal') ? "font-style: ". $attributes['title_font_style'] .";" : '';
		$title_style .= ($attributes['title_font_decoration'] != 'none') ? "text-decoration: ". $attributes['title_font_decoration'] .";" : '';
		$title_style .= ($attributes['title_line_height'] != '40') ? "line-height: ". $attributes['title_line_height'] ."px;" : '';
		$title_style .= ($attributes['title_letter_spacing'] != '0') ? "letter-spacing: ". $attributes['title_letter_spacing'] ."px;" : '';

		$desc_style  = '';
		$desc_style .= ($attributes['desc_color'] != '#fff') ? "color: ". $attributes['desc_color'] .";" : '';
		$desc_style .= ($attributes['desc_font'] != 'inherit') ? "font-family: ". $attributes['desc_font'] .";" : '';
		$desc_style .= ($attributes['desc_font_size'] != '20') ? "font-size: ". $attributes['desc_font_size'] ."px;" : '';
		$desc_style .= ($attributes['desc_font_weight'] != '400') ? "font-weight: ". $attributes['desc_font_weight'] .";" : '';
		$desc_style .= ($attributes['desc_font_transform'] != 'none') ? "text-transform: ". $attributes['desc_font_transform'] .";" : '';
		$desc_style .= ($attributes['desc_font_style'] != 'normal') ? "font-style: ". $attributes['desc_font_style'] .";" : '';
		$desc_style .= ($attributes['desc_font_decoration'] != 'none') ? "text-decoration: ". $attributes['desc_font_decoration'] .";" : '';
		$desc_style .= ($attributes['desc_line_height'] != '20') ? "line-height: ". $attributes['desc_line_height'] ."px;" : '';
		$desc_style .= ($attributes['desc_letter_spacing'] != '0') ? "letter-spacing: ". $attributes['desc_letter_spacing'] ."px;" : '';

		$box_style  = "background: ".$attributes['overlay_color'].";";
		if($attributes['border_radius_top_left'] != '') {
		$box_style .= "border-radius:";
		$box_style .= $attributes['border_radius_top_left'].''.$attributes['border_radius_unit']." ";
		$box_style .= $attributes['border_radius_top_right'].''.$attributes['border_radius_unit']." ";
		$box_style .= $attributes['border_radius_bottom_left'].''.$attributes['border_radius_unit']." ";
		$box_style .= $attributes['border_radius_bottom_right'].''.$attributes['border_radius_unit'].";";
		}

		$caption_style  = "background: ".$attributes['overlay_color'].";";
		$caption_style .= ($attributes['horizontal_flexalignment'] != 'center') ? "align-items: ". $attributes['horizontal_flexalignment'] .";" : '';
		$caption_style .= ($attributes['vertical_flexalignment'] != 'center') ? "justify-content: ". $attributes['vertical_flexalignment'] .";" : '';
		if($attributes['padding_top'] != '' && $attributes['padding_top'] != '30' && $attributes['padding_right'] != '30' && $attributes['padding_bottom'] != '30' && $attributes['padding_left'] != '30') {
		$caption_style .= "padding:";
		$caption_style .= $attributes['padding_top'].''.$attributes['padding_unit']." ";
		$caption_style .= $attributes['padding_right'].''.$attributes['padding_unit']." ";
		$caption_style .= $attributes['padding_bottom'].''.$attributes['padding_unit']." ";
		$caption_style .= $attributes['padding_left'].''.$attributes['padding_unit'].";";
		}

		$icon_style = '';
		$icon_style .= ($attributes['icon_display'] != 'none') ? "display:".$attributes['icon_display'].";" : '';
		$icon_style .= ($attributes['icon_color'] != '#ddd') ? "color:". $attributes['icon_color'].";" : '';
		$icon_style .= ($attributes['icon_size'] != '30') ? "width:".$attributes['icon_size']."px;height:".$attributes['icon_size']."px;font-size: ".$attributes['icon_size']."px;" : '';
		$icon_style .= ($attributes['icon_margin_left'] != '15') ? "margin-left: ".$attributes['icon_margin_left']."px;" : '';
		$icon_style .= ($attributes['icon_margin_right'] != '0') ? "margin-right: ".$attributes['icon_margin_right']."px;" : '';
		$icon_style .= ($attributes['icon_position'] != '0') ? "order: ".$attributes['icon_position'].";" : '';
		
		$box_style 		= ' style="'.$box_style . '"';
		$caption_style 	= ' style="'.$caption_style . '"';
		$icon_style 	= ' style="'.$icon_style . '"';
		$title_style 	= (($title_style != '') ? ' style="'.$title_style . '"' : '');
		$desc_style 	= (($desc_style != '') ? ' style="'.$desc_style . '"' : '');

		// Render Output...
		$iheg_block = "";
		$iheg_block .= ($attributes['linktourl'] != '') ? '<a href="'. $attributes['linktourl'] .'" '. (($attributes['addtarget'] == true)? 'target="_blank"': '') .' '. (($attributes['addrel'] == true) ? 'rel="nofollow"':'') .'>' : '<div>';
		$iheg_block	.= '<div class="eihe-box '.$attributes['hover_effect'].'"'. $box_style .'>';
		$iheg_block	.= '<img src="' . $widgetimg . '" />';
		$iheg_block	.= '<div class="eihe-caption"'. $caption_style .'>';
		$iheg_block	.= '<div class="eihe-title-cover">';
		$iheg_block	.= '<'.$attributes['title_tag']. $title_style .' class="eihe-title">'.$attributes['widget_title'].'</'.$attributes['title_tag'].'>';
		$iheg_block .=	($attributes['icon'] != '') ? '<i'. $icon_style .' class="'. $attributes['icon'] .'"></i>' :'';
		$iheg_block .='	</div>';
		$iheg_block	.= '<p'. $desc_style .'>'.$attributes['widget_description'].'</p>';
		$iheg_block	.= '</div></div>';
		$iheg_block .= ($attributes['linktourl'] != '') ? '</a>' : '</div>';

		return $iheg_block;
	}
}

new ImageHoverEffectsBlock();