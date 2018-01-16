<?php
/**
 * @package ZEIT ONLINE Feeds Widget
 *
 * Plugin Name:       ZEIT ONLINE Feeds Widget
 * Plugin URI:        https://github.com/ZeitOnline/zon-feeds-widget
 * Description:       Shows the blogs own content and comment feed address
 * Version:           1.0.0
 * Author:            Arne Seemann
 * Author URI:        http://www.zeit.de
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * GitHub Plugin URI: https://github.com/ZeitOnline/zon-feeds-widget
*/

add_action( 'widgets_init', array( 'WP_Widget_ZON_Feeds', 'init' ) );

class WP_Widget_ZON_Feeds extends WP_Widget {

	function __construct() {
		// Classname ist der CSS-Klassenname des Widgets. Auch mehrere möglich.
		$widget_ops = array('classname' => 'zon_widget_feeds', 'description' => "Zeigt den zum Blog gehörigen Artikel- & Kommentar-Feed" );

		parent::__construct(
			'feed-widget',
			'ZON Feeds',
			$widget_ops
			);
	}

	public static function init() {
		register_widget( __CLASS__ );
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Meta') : $instance['title']);

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
?>
			<ul>
			<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php echo esc_attr(__('Syndicate this site using RSS 2.0')); ?>"><?php _e('Entries <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
			<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php echo esc_attr(__('The latest comments to all posts in RSS')); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
			</ul>
<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Feeds' ) );
		$title = strip_tags($instance['title']);
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
<?php
	}
}
