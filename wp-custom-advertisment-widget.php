<?php
/*
Plugin Name:	WP Custom Advertisment Widget
Description:	Adds widget displaying clickable image with text overlay to destination URL. 
Plugin URI:		http://brentmercer.com/wp-custom-advertisment-widget
Author:			Brent Mercer
Author URI:     http://brentmercer.com
Version:		1.0.0
License:		GPLv2 or later
License URI:	https://www.gnu.org/licenses/gpl-2.0.txt
Text Domain:    wp-custom-advertisment-widget
Domain Path:    /languages

WP Custom Advertisment Widget is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
WP Custom Advertisment Widget is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with WP Custom Advertisment Widget. If not, see https://www.gnu.org/licenses/gpl-2.0.txt.
*/

/**
 * Register constants.
 * 
 * @since 1.0.0
 * @author Brent Mercer <brentonjmercer@gmail.com>
 * 
 * @param array $instance Defines constants used throughout code below
 */
define( 'WP_AD_WIDGET_IMAGE_TEXTDOMAIN', 'wp-ad-widget-image' );
define( 'WP_AD_WIDGET_IMAGE_DOMAIN', 'wp-ad-widget-image-domain' );
define( 'WP_AD_Widget_Image_TITLE', __( 'WP Custom Advertisment Widget', WP_AD_WIDGET_IMAGE_TEXTDOMAIN ) );

/**
 * Core class used to implement the WP Custom Advertisment Widget.
 *
 * @since 1.0.0
 * @author Brent Mercer <brentonjmercer@gmail.com>
 *
 * @see WP_Widget
 */
class WP_AD_Widget_Image extends WP_Widget{

	/**
	 * Sets up a new Categories widget instance.
	 *
	 * @since 1.0.0
	 * @author Brent Mercer <brentonjmercer@gmail.com>
	 */
	function __construct() {
		$widget_ops = array(
			'classname' => 'wp_ad_widget_image',
			'description' => __( 'Displays clickable image with text overlay to destination URL.', WP_AD_WIDGET_IMAGE_TEXTDOMAIN ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'wp-ad-widget-image', WP_AD_Widget_Image_TITLE, $widget_ops );
		$this->alt_option_name = 'wp_ad_widget_image';
	}

	/**
	 * Outputs the settings form for the WP Custom Advertisment Widget.
	 *
	 * @since 1.0.0
	 * @author Brent Mercer <brentonjmercer@gmail.com>
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : '';
		$image = isset( $instance['image'] ) ? esc_url( $instance['image'] ) : '';
		$link = isset( $instance['link'] ) ? esc_url( $instance['link'] ) : '';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', WP_AD_WIDGET_IMAGE_TEXTDOMAIN ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e( 'Image (URL):', WP_AD_WIDGET_IMAGE_TEXTDOMAIN ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" type="text" value="<?php echo esc_attr( $image ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link (URL):', WP_AD_WIDGET_IMAGE_TEXTDOMAIN ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" />
		</p>
		<?php
	}

	/**
	 * Handles updating settings for the current WP Custom Advertisment Widget instance.
	 *
	 * @since 1.0.0
	 * @author Brent Mercer <brentonjmercer@gmail.com>
	 *
	 * @param array $new_instance New settings for this instance as input by the user via WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['image'] = esc_url_raw( $new_instance['image'] );
		$instance['link'] = esc_url_raw( $new_instance['link'] );
		return $instance;
	}

	/**
	 * Outputs the content for the current WP Custom Advertisment Widget instance.
	 *
	 * @since 1.0.0
	 * @author Brent Mercer <brentonjmercer@gmail.com>
	 *
	 * @param array $args  Display arguments including 'before_title', 'after_title', 'before_widget', and 'after_widget'.
	 * @param array $instance  Settings for the current Categories widget instance.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$image = esc_url( $instance['image'] );
		$link = esc_url( $instance['link'] );

		echo $args['before_widget'];
		?>
		<div>
			<a href="<?php echo $link ?>" target="_blank" class="wp-ad-widget-image-link">
				<div class="wp-ad-widget-image-background" style="background-image: url(<?php echo $image; ?>);">
					<div class="wp-ad-widget-image-overlay">
						<div class="wp-ad-widget-image-wrap"> 
							<div class="wp-ad-widget-image-title">
								<?php
								if ( ! empty( $title ) ) {
									// echo $args['before_title'] . $title . $args['after_title'];
									echo $title;
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>

		<?php
		/**
		 * Block of CSS styles to display the front-end background image and title-text overlay
		 *
		 * @since 1.0.0
		 * @author Brent Mercer <brentonjmercer@gmail.com>
		 */
		?>
		<style type="text/css">
			.wp-ad-widget-image-link { text-decoration: none !important; }
			.wp-ad-widget-image-background {
				height: 250px;
				width: 300px;
				background-position: center center;
				background-repeat: no-repeat;
				z-index: 2;

				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
				
				border: 1px solid #888;
			}
			.wp-ad-widget-image-background .wp-ad-widget-image-overlay {
				height: 100%;
				left: 0;
				top: 0;
				width: 100%;
			}
			.wp-ad-widget-image-background .wp-ad-widget-image-overlay .wp-ad-widget-image-wrap {
				display: table;
				height: 100%;
				position: relative;
				width: 100%;
				z-index: 1;
			}
			.wp-ad-widget-image-title {
				background: none;
				display: table-cell;
				margin: 0;
				padding: 15px;
				color: #fff;
				font-size: 1.75em;
				font-family: PT Serif;
				vertical-align: middle;
				text-align: center;
			}
			.widget_wp-ad-widget-image {
				padding-bottom: 0;
				margin-bottom: 0;
			}
		</style>


		<?php		
		echo $args['after_widget'];
	}
} // Class WP_AD_Widget_Image ends here

/**
 * Initialize plugin basics.
 * 
 * @since 1.0.0
 * @author Brent Mercer <brentonjmercer@gmail.com>
 * 
 * @see register_widget()
 */
function wp_ad_widget_image_init() {
	register_widget( 'WP_AD_Widget_Image' );
}
add_action( 'widgets_init', 'wp_ad_widget_image_init' );