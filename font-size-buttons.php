<?php
/* 
Plugin Name: Font size buttons
Plugin URI:  
Description: 
Author: Viktor Kalajo
Version: 1.0 
Author URI: 
*/  
define('FSB_PATH', WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__) ) . '/' );  
define('FSB_NAME', "Font size buttons");  
define ('FSB_VERSION', "1.0");


function fsb_enque_files() {
	wp_enqueue_script('fon_size_buttons_js', FSB_PATH.'fsb_script.js', array('jquery'));  
	wp_enqueue_style('fon_size_buttons_css', FSB_PATH.'fsb_style.css');
}
add_action('wp_enqueue_scripts', 'fsb_enque_files' );


function get_font_size_buttons() {
	$show_default = true; //show default font size button? 
	return '
<!-- font size buttons -->
<div class="font-size-buttons">
	<img class="font-size-smaller" src="'.FSB_PATH.'/text_smaller.png" alt="Smaller font size"/>'
	.($show_default == true ? 
	'<img class="font-size-default" src="'.FSB_PATH.'/text_default.png" alt="Restore default font size"/>' 
	: '').
	'<img class="font-size-bigger" src="'.FSB_PATH.'/text_bigger.png" alt="Larger font size"/>
</div>
	';
}

function the_font_size_buttons() {
	echo get_font_size_buttons();
}


function fsb_buttons_shortcode( $atts ){
 return get_font_size_buttons();
}
add_shortcode( 'font_size_buttons', 'fsb_buttons_shortcode' );

class Font_size_buttons extends WP_Widget {
 	
 	function __construct()
 	{
 		$params = array(
 			'description' 	=> 'Enables user to change the font size.',
 			'name' 			=> 'Font size buttons'
 			);
 
 		parent::__construct('Font_size_buttons', '', $params);
 	}
 
 	/**
 	 * This function is responsible for displaying the form in admin-area
 	 * @param  [object] $instance [contains is whatever the user puts in to those inputs]
 	 */
 	public function form($instance) 
 	{
		extract($instance);
 
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input 
				class="widefat"
				id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title');?> "
				value="<?php if(isset($title)) echo esc_attr($title); ?>"
		</p>
 
		<?php
		
 	}
 
 	/**
 	 * Responsible for displaying the actual widget on a page
 	 * @param  array $args     widget arguments
 	 * @param  array $instance variables from the form
 	 */
 	public function widget($args, $instance) 
 	{
 		extract($args);
 		extract($instance);
 
 		$title = apply_filters('widget_title', $title);
 		$description = apply_filters('widget_description', $description);
 
 		//standard values
 		if(empty($title)) $title = 'Default title';
 
 		echo $before_widget;
 			echo $before_title . $title . $after_title;
 			the_font_size_buttons();
 		echo $after_widget;
 
 	}
}
 
function fsb_register_widget() 
{
	register_widget('Font_size_buttons');
}
add_action('widgets_init', 'fsb_register_widget');