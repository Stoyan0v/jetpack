<?php

if ( ! class_exists( 'Jetpack_EU_Cookie_Law_Banner_Widget' ) ) {

	//register Jetpack_EU_Cookie_Law_Banner_Widget widget
	function jetpack_eu_cookie_law_banner_init() {
		register_widget( 'Jetpack_EU_Cookie_Law_Banner_Widget' );
	}

	add_action( 'widgets_init', 'jetpack_eu_cookie_law_banner_init' );

	class Jetpack_EU_Cookie_Law_Banner_Widget extends WP_Widget {

		/**
		 * Constructor
		 */
		function __construct() {
			$widget_ops = array(
				'classname' => 'eu_cookie_law_banner',
				'description' => __( 'Display a banner for compliance with the EU Cookie Law.', 'jetpack' ),
				'customize_selective_refresh' => true,
			);
			parent::__construct(
				'eu_cookie_law_banner',
				/** This filter is documented in modules/widgets/facebook-likebox.php */
				apply_filters( 'jetpack_widget_name', __( 'EU Cookie Law Banner', 'jetpack' ) ),
				$widget_ops
			);

			if ( is_customize_preview() ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			}
		}

		/**
		 * Enqueue scripts and styles.
		 */
		public function enqueue_scripts() {
			wp_enqueue_script( 'eu-cookie-law-banner', plugins_url( 'eu-cookie-law-banner/eu-cookie-law-banner.js', __FILE__ ), array( 'jquery' ), 20170215 );
		}


		/**
		 * Return an associative array of default values
		 *
		 * These values are used in new widgets.
		 *
		 * @return array Array of default values for the Widget's options
		 */
		public function defaults() {
			return array(
				'title' => __( 'EU Cookie Law Banner', 'jetpack' ),
			);
		}

		/**
		 * Outputs the HTML for this widget.
		 *
		 * @param array $args     An array of standard parameters for widgets in this theme
		 * @param array $instance An array of settings for this widget instance
		 *
		 * @return void Echoes it's output
		 **/
		function widget( $args, $instance ) {
			$instance = wp_parse_args( $instance, $this->defaults() );

			echo $args['before_widget'];

			if ( '' != $instance['title'] ) {
				echo $args['before_title'] . $instance['title'] . $args['after_title'];
			}

			$this->enqueue_scripts();

			echo $args['after_widget'];

			/** This action is documented in modules/widgets/gravatar-profile.php */
			do_action( 'jetpack_stats_extra', 'widget_view', 'eu_cookie_law_banner' );
		}


		/**
		 * Deals with the settings when they are saved by the admin. Here is
		 * where any validation should be dealt with.
		 *
		 * @param array $new_instance New configuration values
		 * @param array $old_instance Old configuration values
		 *
		 * @return array
		 */
		function update( $new_instance, $old_instance ) {
			$instance          = array();
			$instance['title'] = wp_kses( $new_instance['title'], array() );

			return $instance;
		}


		/**
		 * Displays the form for this widget on the Widgets page of the WP Admin area.
		 *
		 * @param array $instance Instance configuration.
		 *
		 * @return void
		 */
		function form( $instance ) {
			$instance = wp_parse_args( $instance, $this->defaults() );
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'jetpack' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>
			
			<?php
		}

	}

}