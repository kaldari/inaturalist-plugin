<?php
/*
Plugin Name: iNaturalist Plugin
Plugin URI:
Description: A plugin that lets you site interface with iNaturalist
Version: 1.0
Author: Kaldari
License: MIT
*/

class inat_login_widget extends WP_Widget {

	// constructor
	function __construct() {
		$widget_ops = array(
			'classname' => 'inat-login',
			'description' => __( 'Allows users to log into their iNaturalist accounts', 'wp_inaturalist' ) );
		parent::WP_Widget( false, $name = __( 'iNaturalist Login', 'wp_inaturalist' ), $widget_ops );
	}

	// widget form creation
	function form( $instance ) {
		// Check values
		if ( $instance ) {
			 $title = esc_attr( $instance['title'] );
			 $createAccount = esc_attr( $instance['createAccount'] );
		} else {
			 $title = __( 'Log in to iNaturalist', 'wp_inaturalist' );
			 $createAccount = '';
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Header Text:', 'wp_inaturalist' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
		<p>
		<input id="<?php echo $this->get_field_id( 'createAccount' ); ?>" name="<?php echo $this->get_field_name( 'createAccount' ); ?>" type="checkbox" value="1" <?php checked( '1', $createAccount ); ?> />
		<label for="<?php echo $this->get_field_id( 'createAccount' ); ?>"><?php _e( 'Include link to create new account', 'wp_inaturalist' ); ?></label>
		</p>
		<?php
	}

	// update widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		// Fields
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['createAccount'] = strip_tags( $new_instance['createAccount'] );
		return $instance;
	}

	// display widget
	function widget( $args, $instance ) {
		extract( $args );
		// These are the widget options
		$title = apply_filters( 'widget_title', $instance['title'] );
		$createAccount = $instance['createAccount'];
		echo $before_widget;

		// Display the widget
		echo '<div class="widget-text wp_widget_plugin_box">';

		// Check if title is set
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
	
		?>
		<form action="login.action.php" method="post">
		<p>
			<label for="login">Username</label>
			<input type="text" name="login" pattern=".{3,40}" required />
			<!--Allowed values: Must be within 3 and 40 characters and must not begin with a number.-->
		</p>
		<p>
			<label for="password">Password</label>
			<input type="password" name="password" id="password" pattern=".{5,}" required />
			<!--Allowed values: Minimum 5 characters (this is not inat specified)-->
		</p>
		<?php
		// Check if creating new accounts is allowed
		if ( $createAccount ) {
			echo "<p>\n";
			echo "<a href='register.block.php' class='small'>" .
				__( 'Create a new account', 'wp_inaturalist' ) .
				"</a><br/>\n";
			echo "</p>\n";
		}
		?>
		<p>
			<input type="submit" value="<?php _e( 'Login', 'wp_inaturalist' ); ?>"/>
		</p>
		</form>
		<?php
	
		echo '</div>';
		echo $after_widget;
	}

}

class inat_add_observation_widget extends WP_Widget {

	// constructor
	function __construct() {
		$widget_ops = array(
			'classname' => 'inat-add-observation',
			'description' => __( 'Allows users to add new observations', 'wp_inaturalist' ) );
		parent::WP_Widget( false, $name = __( 'iNaturalist Add Observation', 'wp_inaturalist'), $widget_ops );
	}

	// widget form creation
	function form( $instance ) {
		// Check values
		if ( $instance ) {
			 $title = esc_attr( $instance['title'] );
		} else {
			 $title = __( 'Add an observation', 'wp_inaturalist' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Header Text:', 'wp_inaturalist' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<?php
	}

	// update widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		// Fields
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}

	// display widget
	function widget( $args, $instance ) {
		extract( $args );
		// These are the widget options
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;

		// Display the widget
		echo '<div class="widget-text wp_widget_plugin_box">';

		// Check if title is set
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
	
		?>
		<form action="add.obs.action.php" method="post">
		</form>
		<?php
	
		echo '</div>';
		echo $after_widget;
	}

}

// register widgets
add_action( 'widgets_init', 'load_widgets' );

function load_widgets() {
    register_widget( 'inat_login_widget' );
    register_widget( 'inat_add_observation_widget' );
}
