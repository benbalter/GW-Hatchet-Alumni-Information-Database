<?php

/**
 * Plugin Name: Donations
 * Description: Donations to The GW Hatchet Alumni Association
 * Author: Andrew Nacin
 */

class GWH_Donations {
	static $instance;
	const pt = 'gwh_donation';

	function __construct() {
		$this->instance = $this;
		$actions = array( 'init', 'admin_enqueue_scripts' );
		foreach ( $actions as $action )
			add_action( $action, array( $this, $action ) );

		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );

		add_filter( 'gettext', array( $this, 'gettext' ), 10, 2 );

		add_action( 'manage_' . self::pt . '_posts_custom_column', array( $this, 'manage_pt_posts_custom_column' ), 10, 2 );
		add_filter( 'manage_' . self::pt . '_posts_columns', array( $this, 'manage_pt_posts_columns' ) );
	}

	function save_post( $post_id, $post ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;
		if ( ! current_user_can( 'manage_options' ) )
			return;
		if ( ! wp_verify_nonce( $_POST['_nonce_donations_meta_box'], 'donations_meta-' . $post_id ) )
			return;
		if ( self::pt !== $post->post_type )
			return;
		if ( ! isset( $_POST['donation'] ) )
			return;

		$amount = floatval( trim( $_POST['donation']['amount'], '$' ) );
		$notes = wp_filter_kses( $_POST['notes'] );

		update_post_meta( $post_id, '_donation_amount', $amount );
		update_post_meta( $post_id, '_donation_notes', $notes );	
	}

	function manage_pt_posts_custom_column( $column, $post_id ) {
		switch ( $column ) {
			case 'donation_amount' :
				echo get_post_meta( $post_id, '_donation_amount', true );
				break;
			case 'donation_notes' :
				echo get_post_meta( $post_id, '_donation_notes', true );
				break;
		}
	}

	function manage_pt_posts_columns( $columns ) {
		$columns = array(
			'cb' => $columns['cb'],
			'title' => '(Title)',
			'author' => 'Member',
			'donation_amount' => 'Donation',
			'donation_notes' => 'Notes',
			'date' => 'Donated',
		);
		return $columns;
	}

	function init() {

		$args = array(
			'labels' => array(
				'name' => 'Donations',
				'singular_name' => 'Donation',
				'add_new' => 'Add New',
				'add_new_item' => 'Add New Donation',
				'edit_item' => 'Edit Donation',
				'new_item' => 'New Donation',
				'view_item' => 'View Donation',
				'search_items' => 'Search Donations',
				'not_found' => 'No donations found.',
				'not_found_in_trash' => 'No donations found in trash.',
			),
			'show_ui' => true,
			'public' => false,
			'capabilities' => array(
				'edit_post'          => 'manage_options',
				'edit_posts'         => 'manage_options',
				'edit_others_posts'  => 'manage_options',
				'publish_posts'      => 'manage_options',
				'read_post'          => 'manage_options',
				'read_private_posts' => 'manage_options',
				'delete_post'        => 'manage_options',
			),
			'rewrite' => false,
			'query_var' => false,
			'supports' => array( false ),
			'register_meta_box_cb' => array( $this, 'register_meta_box_cb' ),
		);
		register_post_type( self::pt, $args );
	}

	function admin_enqueue_scripts( $hook ) {
		$screen = get_current_screen();
		if ( 'gwh_donation' === $screen->id )
			wp_enqueue_style( self::pt, plugins_url( 'css/donations.css', __FILE__ ) );
	}

	function register_meta_box_cb( $post ) {
		add_meta_box( 'donation-data', 'This Donation', array( $this, 'meta_box_data' ), self::pt, 'normal' );
//		add_meta_box( 'donation-save', 'Save', array( $this, 'meta_box_save' ), self::pt, 'normal' );
		remove_meta_box('submitdiv', self::pt, 'side' );
	}

	function meta_box_data( $post, $args ) {
		wp_nonce_field( 'donations_meta-' . $post->ID, '_nonce_donations_meta_box' );
		touch_time( true, 1, false, true ); ?>
		<p><label for="user">Member</label> <?php
		wp_dropdown_users( array(
			'name' => 'post_author_override',
			'selected' => empty( $post->ID ) ? $user_ID : $post->post_author,
			'include_selected' => true
		) ); ?></p>
		<p><label for="donation-amount">Amount</label> $<input type="text" id="donation-amount" name="donation[amount]" value="<?php echo esc_attr( get_post_meta( $post->ID, '_donation_amount', true ) ); ?>" /></p>
		<p><label for="donation-notes">Notes</label>
		<textarea rows="1" cols="40" name="donation[notes]" id="excerpt"><?php echo "\n" . esc_textarea( get_post_meta( $post->ID, '_donation_notes', true ) ); ?></textarea>
		
		
<div id="major-publishing-actions" class="submitbox">
<div id="delete-action">
<a class="submitdelete deletion" href="<?php echo get_delete_post_link( $post->ID, null, true ); ?>">Delete Donation</a>
</div>

<div id="publishing-action">
<img src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" class="ajax-loading" id="ajax-loading" alt="" />
<input name="original_publish" type="hidden" id="original_publish" value="Save" />
<?php submit_button( __( 'Save' ), 'primary', 'publish', false ); ?>
</div>
<div class="clear"></div>
</div>
</div>
<?php
	}

	function gettext( $translated, $text ) {
		switch ( $text ) {
			case '%1$s%2$s, %3$s @ %4$s : %5$s' :
				return '%1$s%2$s, %3$s';
			default :
				return $text;
		}
	}

}

new GWH_Donations;