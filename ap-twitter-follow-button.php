<?php
/*
Plugin Name: AP Twitter Follow Button
Plugin URI: http://armelpingault.com/wordpress-plugin-ap-twitter-follow-button/
Description: AP Twitter Follow Button add a widget which allows you to add a highly cutomizable Twitter Follow Button.
Author: Armel Pingault
Version: 0.9.2
Author URI: http://armelpingault.com/
*/

/**
 * AP Twitter Follow Button widget class
 */
class AP_Twitter_Follow_Button extends WP_Widget {
	
	/**
	 * Register widget with WordPress.
	 */
	public function AP_Twitter_Follow_Button() {
		$widget_ops = array(
			'classname'   => 'ap_twitter_follow_button',
			'description' => __( "AP Twitter Follow Button add a widget which allows you to add a highly cutomizable Twitter Follow Button.")
		);
		parent::__construct( 'ap-twitter-follow-button', __('AP Twitter Follow Button'), $widget_ops );
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );

		$title         = apply_filters('widget_title', $instance['title']);
		$username      = $instance['username'];
		$language      = $instance['language'];
		$show_count    = (boolean) $instance['show_count'];
		$show_username = (boolean) $instance['show_username'];
		$large_button  = (boolean) $instance['large_button'];
		$dtn           = (boolean) $instance['dtn'];
		$no_javascript = isset($instance['no_javascript']) ? (boolean) $instance['no_javascript'] : false;
		$text_align    = isset($instance['text_align']) ? $instance['text_align'] : false;
		$width_limit   = (boolean) $instance['width_limit'];
		$width_value   = isset($instance['width_value']) ? (int) $instance['width_value'] : false;
		$width_unit    = $instance['width_unit'];
		
		echo $before_widget;
		
		if ( $title ) echo $before_title . $title . $after_title;
		
		if ( $width_limit || $text_align ) {
			
			$style = '';
			if ( $width_limit )
				$style .= ';width:' . $width_value . $width_unit;
			if ( $text_align )
				$style .= ';text-align:' . $text_align . ';';
			
			echo '<div style="overflow:hidden' . $style . '">';
		}
			
		?>
                
		<a href="https://twitter.com/<?php echo $username; ?>" class="twitter-follow-button" data-show-count="<?php echo ( $show_count ) ? 'true' : 'false'; ?>" data-show-screen-name="<?php echo ( $show_username ) ? 'true' : 'false'; ?>" data-dnt="<?php echo ( $dtn ) ? 'true' : 'false'; ?>"<?php if ( $large_button ) echo ' data-size="large"'; ?><?php if ( $language !== '' ) echo ' data-lang="' . $language . '"'; ?>>Follow @<?php echo $username; ?></a>
		<?php if ( ! $no_javascript ) : ?>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		<?php endif; ?>
                
		<?php
		if ( $width_limit || $text_align ) echo '</div>';
                
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']         = strip_tags($new_instance['title']);
		$instance['username']      = strip_tags($new_instance['username']);
		$instance['language']      = strip_tags($new_instance['language']);
		$instance['show_count']    = (boolean) $new_instance['show_count'];
		$instance['show_username'] = (boolean) $new_instance['show_username'];
		$instance['large_button']  = (boolean) $new_instance['large_button'];
		$instance['dtn']           = (boolean) $new_instance['dtn'];
		$instance['no_javascript'] = (boolean) $new_instance['no_javascript'];
		$instance['text_align']    = strip_tags($new_instance['text_align']);
		$instance['width_limit']   = (boolean) $new_instance['width_limit'];
		$instance['width_value']   = strip_tags($new_instance['width_value']);
		$instance['width_unit']    = strip_tags($new_instance['width_unit']);

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	function form( $instance ) {
		$title         = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$username      = isset($instance['username']) ? esc_attr($instance['username']) : '';
		$language      = isset($instance['language']) ? esc_attr($instance['language']) : '';
		$show_count    = isset($instance['show_count']) ? (boolean) $instance['show_count'] : false;
		$show_username = isset($instance['show_username']) ? (boolean) $instance['show_username'] : false;
		$large_button  = isset($instance['large_button']) ? (boolean) $instance['large_button'] : false;
		$dtn           = isset($instance['dtn']) ? (boolean) $instance['dtn'] : false;
		$no_javascript = isset($instance['no_javascript']) ? (boolean) $instance['no_javascript'] : false;
		$text_align    = isset($instance['text_align']) ? esc_attr($instance['text_align']) : '';
		$width_limit   = isset($instance['width_limit']) ? (boolean) $instance['width_limit'] : false;
		$width_value   = isset($instance['width_value']) ? esc_attr($instance['width_value']) : '';
		$width_unit    = isset($instance['width_unit']) ? esc_attr($instance['width_unit']) : 'px';
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Twitter username:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $username; ?>" />
		</p>
		<?php
		$arr_lang = array(
			''	    => 'Select Language ...&nbsp;',
			'th'	=> 'Thai - ภาษาไทย',
			'he'	=> 'Hebrew - עִבְרִית',
			'hu'	=> 'Hungarian - Magyar',
			'fil'	=> 'Filipino - Filipino',
			'nl'	=> 'Dutch - Nederlands',
			'fr'	=> 'French - français',
			'es'	=> 'Spanish - Español',
			'fi'	=> 'Finnish - Suomi',
			'de'	=> 'German - Deutsch',
			'zh-tw'	=> 'Traditional Chinese - 繁體中文',
			'pt'	=> 'Portuguese - Português',
			'pl'	=> 'Polish - Polski',
			'no'	=> 'Norwegian - Norsk',
			'zh-cn'	=> 'Simplified Chinese - 简体中文',
			'msa'	=> 'Malay - Bahasa Melayu',
			'fa'	=> 'Farsi - فارسی',
			'sv'	=> 'Swedish - Svenska',
			'da'	=> 'Danish - Dansk',
			'ur'	=> 'Urdu - اردو',
			'hi'	=> 'Hindi - हिन्दी',
			'ru'	=> 'Russian - Русский',
			'id'	=> 'Indonesian - Bahasa Indonesia',
			'it'	=> 'Italian - Italiano',
			'tr'	=> 'Turkish - Türkçe',
			'en'	=> 'English',
			'ko'	=> 'Korean - 한국어',
			'ja'	=> 'Japanese - 日本語',
			'ar'	=> 'Arabic - العربية'
		);
		?>		
		<p>
			<label for="<?php echo $this->get_field_id('language'); ?>"><?php _e('Language:'); ?></label>
			<select id="<?php echo $this->get_field_id('language'); ?>" name="<?php echo $this->get_field_name('language'); ?>" class="widefat">
				<?php foreach ($arr_lang as $lang_id => $lang_name ) : ?>
					<option value="<?php echo $lang_id; ?>"<?php if ( $lang_id === $language ) echo ' selected="selected"'; ?>><?php echo $lang_name; ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('text_align'); ?>"><?php _e('Alignment:'); ?></label>
			<?php
			$arr_align = array(
				''       => 'None',
				'left'   => 'Left',
				'center' => 'Center',
				'right'  => 'Right'
			);
			?>		
			<select id="<?php echo $this->get_field_id('text_align'); ?>" name="<?php echo $this->get_field_name('text_align'); ?>" class="widefat">
				<?php foreach ($arr_align as $align_id => $align_value ) : ?>
					<option value="<?php echo $align_id; ?>"<?php if ( $align_id == $text_align ) echo ' selected="selected"'; ?>><?php echo $align_value; ?></option>
				<?php endforeach; ?>
			</select>
		</p>		
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_count'); ?>" name="<?php echo $this->get_field_name('show_count'); ?>"<?php if ( $show_count ) echo ' checked="checked"'; ?> />
			<label for="<?php echo $this->get_field_id('show_count'); ?>"><?php _e('Show count'); ?></label>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_username'); ?>" name="<?php echo $this->get_field_name('show_username'); ?>"<?php if ( $show_username ) echo ' checked="checked"'; ?> />
			<label for="<?php echo $this->get_field_id('show_username'); ?>"><?php _e('Show username'); ?></label>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('large_button'); ?>" name="<?php echo $this->get_field_name('large_button'); ?>"<?php if ( $large_button ) echo ' checked="checked"'; ?> />
			<label for="<?php echo $this->get_field_id('large_button'); ?>"><?php _e('Large button'); ?></label>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('dtn'); ?>" name="<?php echo $this->get_field_name('dtn'); ?>"<?php if ( $dtn ) echo ' checked="checked"'; ?> />
			<label for="<?php echo $this->get_field_id('dtn'); ?>"><?php _e('Opt-out of tailoring Twitter'); ?></label>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('no_javascript'); ?>" name="<?php echo $this->get_field_name('no_javascript'); ?>"<?php if ( $no_javascript ) echo ' checked="checked"'; ?> />
			<label for="<?php echo $this->get_field_id('no_javascript'); ?>"><?php _e('Do NOT load widgets.js file'); ?></label>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('width_limit'); ?>" name="<?php echo $this->get_field_name('width_limit'); ?>"<?php if ( $width_limit ) echo ' checked="checked"'; ?> />
			<label for="<?php echo $this->get_field_id('width_limit'); ?>"><?php _e('Width limit'); ?></label>
			<input id="<?php echo $this->get_field_id('width_value'); ?>" name="<?php echo $this->get_field_name('width_value'); ?>" type="text" value="<?php echo $width_value; ?>" size="4" />
			<?php
			$arr_units = array(
				'px' => 'px',
				'pc' => '%',
				'em' => 'em'
			);
			?>		
			<select id="<?php echo $this->get_field_id('width_unit'); ?>" name="<?php echo $this->get_field_name('width_unit'); ?>">
				<?php foreach ($arr_units as $unit_id => $unit_value ) : ?>
					<option value="<?php echo $unit_id; ?>"<?php if ( $unit_id === $width_unit ) echo ' selected="selected"'; ?>><?php echo $unit_value; ?></option>
				<?php endforeach; ?>
			</select>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					var $width_limit = $('#<?php echo $this->get_field_id('width_limit'); ?>'),
					    $width_value = $('#<?php echo $this->get_field_id('width_value'); ?>'),
					    $width_unit = $('#<?php echo $this->get_field_id('width_unit'); ?>');
					
					var toggleWidth = function() {
						if ($width_limit.is(':checked')) {
							$width_value.removeAttr('disabled');
							$width_unit.removeAttr('disabled');
						} else {
							$width_value.attr('disabled', 'disabled');
							$width_unit.attr('disabled', 'disabled');
						}
					}
					
					$width_limit.on('click', toggleWidth);
					toggleWidth();
				});
			</script>
		</p>
		<?php
	}
} // class AP_Twitter_Follow_Button

add_action( 'widgets_init', create_function('', 'return register_widget("AP_Twitter_Follow_Button");') );