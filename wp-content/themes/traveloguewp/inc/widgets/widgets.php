<?php 
/* ========= travelogue_Tweets_Widget ===================================== */
class Travelogue_Tweets_Widget extends WP_Widget {

	function __construct() {
		parent::__construct('Travelogue_Tweets_Widget', __('Travelogue Recent Tweets', 'travelogue'),array( 'description' => __( 'Recent tweets widget', 'travelogue' ), ) );
	}


	public function widget( $args, $instance ) {
		$recent_tweets_pol_title = esc_attr( $instance[ 'recent_tweets_pol_title' ] );
		$recent_tweets_pol_number = esc_attr( $instance[ 'travelogue_tweets_number' ] );
		echo $args['before_widget'];
		echo do_shortcode("[tweets title='{$recent_tweets_pol_title}' no='{$recent_tweets_pol_number}'][/tweets]");
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		if ( isset( $instance[ 'recent_tweets_pol_title' ] ) ) {
			$recent_tweets_pol_title = esc_attr( $instance[ 'recent_tweets_pol_title' ] );
		}
		else {
			$recent_tweets_pol_title = __( 'Recent Tweets', 'travelogue' );
		}

		if ( isset( $instance[ 'travelogue_tweets_number' ] ) ) {
			$recent_tweets_pol_number = esc_attr( $instance[ 'travelogue_tweets_number' ] );
		}
		else {
			$recent_tweets_pol_number = 2;
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'recent_tweets_pol_title' ); ?>"><?php _e( 'Widget title:','travelogue' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'recent_tweets_pol_title' ); ?>" name="<?php echo $this->get_field_name( 'recent_tweets_pol_title' ); ?>" type="text" value="<?php echo esc_attr( $recent_tweets_pol_title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'travelogue_tweets_number' ); ?>"><?php _e( 'Tweets number:','travelogue' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'travelogue_tweets_number' ); ?>" name="<?php echo $this->get_field_name( 'travelogue_tweets_number' ); ?>" type="text" value="<?php echo esc_attr( $recent_tweets_pol_number ); ?>">
		</p>
		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['recent_tweets_pol_title'] = ( ! empty( $new_instance['recent_tweets_pol_title'] ) ) ?  $new_instance['recent_tweets_pol_title']  : '';
		$instance['travelogue_tweets_number'] = ( ! empty( $new_instance['travelogue_tweets_number'] ) ) ?  $new_instance['travelogue_tweets_number']  : 2;
		return $instance;
	}

} 






/* ========= Travelogue_Contact_Widget ===================================== */
class Travelogue_Contact_Widget extends WP_Widget {

    function __construct() {
        parent::__construct('Travelogue_Contact_Widget', __('Travelogue Contact Us', 'travelogue'),array( 'description' => __( 'Travelogue Contact Widget', 'travelogue' ), ) );
    }

    public function widget( $args, $instance ) {
        global $travelogue_redux_options;
        $widget_title = $instance[ 'widget_title' ];

        echo $args['before_widget']; ?>

        <div class="sidebar-social-networks">
            <?php if($widget_title) { ?>
	           <h4 class="widget-title"><?php echo $widget_title; ?></h4>
            <?php } ?>
			<ul>
            <?php if ( isset($travelogue_redux_options['travelogue_social_fb']) && $travelogue_redux_options['travelogue_social_fb'] != '' ) { ?>
				<li class="facebook"><a href="<?php echo esc_attr( $travelogue_redux_options['travelogue_social_fb'] ) ?>"><i class="fa fa-facebook"></i></a></li>
            <?php } ?>
			<?php if ( isset($travelogue_redux_options['travelogue_social_tw']) && $travelogue_redux_options['travelogue_social_tw'] != '' ) { ?>
				<li class="twitter"><a href="https://twitter.com/<?php echo esc_attr( $travelogue_redux_options['travelogue_social_tw'] ) ?>"><i class="fa fa-twitter"></i></a></li>
			<?php } ?>
			<?php if ( isset($travelogue_redux_options['travelogue_social_google_plus']) && $travelogue_redux_options['travelogue_social_google_plus'] != '' ) { ?>
				<li class="googleplus"><a href="<?php echo esc_attr( $travelogue_redux_options['travelogue_social_google_plus'] ) ?>"><i class="fa fa-google-plus"></i></a></li>
			<?php } ?>
			<?php if ( isset($travelogue_redux_options['travelogue_social_youtube']) && $travelogue_redux_options['travelogue_social_youtube'] != '' ) { ?>
				<li class="youtube"><a href="<?php echo esc_attr( $travelogue_redux_options['travelogue_social_youtube'] ) ?>"><i class="fa fa-youtube"></i></a></li>
			<?php } ?>
			<?php if ( isset($travelogue_redux_options['travelogue_social_pinterest']) && $travelogue_redux_options['travelogue_social_pinterest'] != '' ) { ?>
				<li class="pinterest"><a href="<?php echo esc_attr( $travelogue_redux_options['travelogue_social_pinterest'] ) ?>"><i class="fa fa-pinterest"></i></a></li>
			<?php } ?>
			<?php if ( isset($travelogue_redux_options['travelogue_social_linkedin']) && $travelogue_redux_options['travelogue_social_pinterest'] != '' ) { ?>
				<li class="linkedin"><a href="<?php echo esc_attr( $travelogue_redux_options['travelogue_social_linkedin'] ) ?>"><i class="fa fa-linkedin"></i></a></li>
			<?php } ?>
			</ul>
       	</div>
        <?php echo $args['after_widget'];
    }

    public function form( $instance ) {
        
        # Widget Title
        if ( isset( $instance[ 'widget_title' ] ) ) {
            $widget_title = $instance[ 'widget_title' ];
        } else {
            $widget_title = __( 'Contact us', 'travelogue' );;
        }

        ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'widget_title' ); ?>"><?php _e( 'Widget Title:','travelogue' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'widget_title' ); ?>" name="<?php echo $this->get_field_name( 'widget_title' ); ?>" type="text" value="<?php echo esc_attr( $widget_title ); ?>">
        </p>
        <p><?php _e( '* Social Network account must be set from Travelogue Theme Panel.','travelogue' ); ?></p>
        <?php 
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['widget_title'] = ( ! empty( $new_instance['widget_title'] ) ) ?  $new_instance['widget_title']  : '';

        return $instance;
    }
}








// Register Widgets
function travelogue_register_widgets() {
    register_widget( 'Travelogue_Tweets_Widget' );
    register_widget( 'Travelogue_Contact_Widget' );

}
add_action( 'widgets_init', 'travelogue_register_widgets' );
?>