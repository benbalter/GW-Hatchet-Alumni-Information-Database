<?php
/*
Plugin Name: GW Hatchet Alumni Information Database
Plugin URI: http://alumni.gwhatchet.com
Description: Stores info about people
Version: 0.1a
Author: Benjamin J. Balter, Alex Byers, Andrew Nacin
Author URI: http://alumni.gwhatchet.com
License: GPL2
*/

class GWHAID {
	static $instance;
	public $prefix = 'gwhaid_';

	/**
	 * Constructor function for hooks
	 */
	function __construct() {
		self::$instance = $this;
		add_filter('rewrite_rules_array', array( $this, 'rewrite_rules' ) );
		add_action('template_redirect', array( $this, 'template_intercept') );
		add_filter('query_vars', array( $this, 'query_var' ) );

		//TESTING ONLY
		add_action('init', 'flush_rewrite_rules' );
	}
	
	
	/**
	 * Default field values
	 */
	function field_defaults() {
		return array( 
			'name' => '',
			'label' => '',
			'permissions' => array( 
				'global_read' => false,
				'user_write' => false,
			),
			'group' => '',
			'multiple' => false,
			'required' => false,
			'type' => 'text',
			'choices' => array(),
			'value' => '',
		);	

	}
	
	/**
	 * Array of fields
	 */
	function fields() {
	
		return array(
		
			'name' => array(
				'label' => 'Basic Information',
				'class' => 'form-group names',
				'fields' => array( 
					array( 
						'name' => 'fname',
						'label' => 'First Name',
						'permissions' => array( 
							'global_read' => true,
							'user_write' => true,
						),
						'group' => 'name',
						'multiple' => false,
						'required' => true,
						'type' => 'text',
					),
					array( 
						'name' => 'lname',
						'label' => 'Last Name',
						'permissions' => array( 
							'global_read' => true,
							'user_write' => true,
						),
						'group' => 'name',
						'multiple' => false,
						'required' => true,
						'type' => 'text',				
					),
					array( 
						'name' => 'mname',
						'label' => 'Maden Name',
						'permissions' => array( 
							'global_read' => true,
							'user_write' => true,
						),
						'group' => 'name',
						'multiple' => false,
						'required' => false,
						'type' => 'text',				
					),
				),
			),
			'emails' => array(
				'label' => '',
				'class' => 'form-group emails',
				'fields' => array(
					array( 
						'name' => 'email',
						'label' => 'E-Mail Address',
						'permissions' => array( 
							'global_read' => true,
							'user_write' => true,
						),
						'group' => '',
						'multiple' => false,
						'required' => true,
						'type' => 'text',
					),
					array( 
						'name' => 'email2',
						'label' => 'Secondary E-Mail',
						'permissions' => array( 
							'global_read' => true,
							'user_write' => true,
						),
						'group' => '',
						'multiple' => false,
						'required' => false,
						'type' => 'text',
					),
				),
			),		
			'year' => array(
				'label' => '',
				'class' => 'form-group year',
				'fields' => array(
					array( 
						'name' => 'grad_year',
						'label' => 'Grad Year',
						'permissions' => array( 
							'global_read' => true,
							'user_write' => true,
						),
						'group' => '',
						'multiple' => false,
						'required' => true,
						'type' => 'text',
					),
				),			
			),			
			'positions' => array(
				'label' => 'Hatchet Positions',
				'class' => '',
				'fields' => array(
					array( 
						'name' => 'hatchet_position',
						'label' => 'Position(s) Held at Hatchet',
						'permissions' => array( 
							'global_read' => true,
							'user_write' => true,
						),
						'group' => '',
						'multiple' => true,
						'required' => true,
						'type' => 'text',
					),
				),
			),	
			'employers' => array(	
				'label' => 'Employers',
				'class' => '',
				'fields' => array(
					array( 
						'name' => 'employer',
						'label' => 'Employer',
						'permissions' => array( 
							'global_read' => true,
							'user_write' => true,
						),
						'group' => 'employer',
						'multiple' => true,
						'required' => false,
						'type' => 'text',
					),			
					array( 
						'name' => 'position',
						'label' => 'Position',
						'permissions' => array( 
							'global_read' => true,
							'user_write' => true,
						),
						'group' => 'employer',
						'multiple' => true,
						'required' => false,
						'type' => 'text',
					),	
					array( 
						'name' => 'work_here_now',
						'label' => 'I currently work here',
						'permissions' => array( 
							'global_read' => true,
							'user_write' => true,
						),
						'choices' => array('Yes', 'No'),
						'group' => 'employer',
						'multiple' => true,
						'required' => false,
						'type' => 'checkbox',
					),	
				),
			),			
			'contact-info' => array(
				'label' => 'Contact Information',
				'class' => '',
				'fields' => array(
					array( 
						'name' => 'phone',
						'label' => 'Phone Number',
						'permissions' => array( 
							'global_read' => false,
							'user_write' => true,
						),
						'group' => '',
						'multiple' => false,
						'required' => false,
						'type' => 'text',
					),			
					array( 
						'name' => 'address',
						'label' => 'Street Address',
						'permissions' => array( 
							'global_read' => false,
							'user_write' => true,
						),
						'group' => 'address',
						'multiple' => false,
						'required' => false,
						'type' => 'text',
					),																								
					array( 
						'name' => 'city',
						'label' => 'City',
						'permissions' => array( 
							'global_read' => false,
							'user_write' => true,
						),
						'group' => 'address',
						'multiple' => false,
						'required' => false,
						'type' => 'text',
					),				
					array( 
						'name' => 'state',
						'label' => 'State',
						'permissions' => array( 
							'global_read' => false,
							'user_write' => true,
						),
						'group' => 'address',
						'multiple' => false,
						'required' => false,
						'type' => 'text',
					),	
					array( 
						'name' => 'zip',
						'label' => 'Zip Code',
						'permissions' => array( 
							'global_read' => false,
							'user_write' => true,
						),
						'group' => 'address',
						'multiple' => false,
						'required' => false,
						'type' => 'text',
					),	
					array( 
						'name' => 'country',
						'label' => 'Country',
						'permissions' => array( 
							'global_read' => false,
							'user_write' => true,
						),
						'group' => 'address',
						'multiple' => false,
						'required' => false,
						'type' => 'text',
					),	
					array( 
						'name' => 'twitter',
						'label' => 'Twitter Handle',
						'permissions' => array( 
							'global_read' => false,
							'user_write' => true,
						),
						'group' => '',
						'multiple' => false,
						'required' => false,
						'type' => 'text',
					),	
				),	
			),	
			'admin' => array(
				'lablel' => 'Admin Fields',
				'class' => '',			
				'fields' => array(
					array( 
						'name' => 'membership_status',
						'label' => 'Membership Status',
						'permissions' => array( 
							'global_read' => false,
							'user_write' => false,
						),
						'group' => '',
						'multiple' => false,
						'required' => false,
						'type' => 'radio',
						'choices' => array( 
							'Current Member', 'Previously Paying Member', 'Never been a member',
						),
					),	
					array( 
						'name' => 'previously_prospected',
						'label' => 'Has this person been previosly prospected for fundraising?',
						'permissions' => array( 
							'global_read' => false,
							'user_write' => false,
						),
						'group' => '',
						'multiple' => false,
						'required' => false,
						'type' => 'radio',
						'choices' => array( 
							'Yes', 'No',
						),
					),	
					array( 
						'name' => 'gwid',
						'label' => 'GWID',
						'permissions' => array( 
							'global_read' => false,
							'user_write' => false,
						),
						'group' => '',
						'multiple' => false,
						'required' => false,
						'type' => 'text',
					),	
						
				),
			),
		);
		
	}

	/**
	 * adds our rewrite rules
	 * @param array $rules original rules
	 * @returns array modified rules
	 */
	function rewrite_rules( $rules ) {

		$newrules[ 'user/?$'] = 'index.php?gwhaid=1';
		$newrules[ 'user/([^/]+)/?$'] = 'index.php?gwhaid=1&user=$matches[1]';
		return $newrules + $rules;
		
	
	}

	/**
	 * Intercepts template redirect and hijacks template as necessary
	 */
	function template_intercept() {
	 		
	 	global $wp_query;
	 	
	 	if( isset($wp_query->query_vars['gwhaid']) ) {	
	 	
	 		//check requested user exists
	 		$user = get_query_var('user');
	 		if ( $user && !get_user_by('slug', $user) ) {
	 			$wp_query->set_404();
	 			return;	
	 		}
			 
			// if not logged in, request auth
			if ( ! is_user_logged_in() ) {
	 			wp_redirect( wp_login_url( home_url( '/user/' ) ) );
				exit;
			}
	 		
	 		wp_enqueue_script( 'gwhaid', plugins_url( 'js.js', __FILE__ ), array('jquery' ), filemtime( dirname(__FILE__) . '/js.js' ), true );
	 		wp_enqueue_style( 'gwhaid', plugins_url( 'style.css', __FILE__ ) );
	 		
			add_filter( 'template_include', array($this, 'template_filter' ) );
		
		}
	
	}

	/**
	 * Filter helper function for template_intercept
	 * @param string $template original template
	 * @returns string path to our template
	 */
	function template_filter( $template ) {
		
		return dirname( __FILE__ ) . '/form.php';
		
	}
	
	/**
	 * Tells WP we have query vars
	 * @param array $vars original query vars
	 * @returns array modified query vars
	 */
	function query_var( $vars ) {
	
		$vars[] = "gwhaid";
		$vars[] = "user";	
		return $vars;
	
	}
	/**
	 * Generate a form input field
	 *
	 * @param string $name The name of the input field
	 * @param string $desc The label to associate with the field
	 * @param string $type The type of input, can be text, textarea, select, radio, checkbox, hidden, password, file, submit or reset
	 * @param bool $required if the field is required
	 * @param string $value The value to set the field to on load
	 * @param array $choices Choices to pass to radio, select, and checkbox inputs
	 * @param int $size Size param to pass to input tag
	 * @param string $args Additional arguments to pass to input tag such as onClick or onChange functions
	 * @param string $helptext Helptext
	 */
	function make_field( $name, $type, $value="", $choices=array() ) {
			switch($type) {
				case 'text':
					$this->make_text_field($name,$value);
				break;
				case 'textarea':
					$this->make_textarea_field($name,$value);
				break;
				case 'select':
					$this->make_select_field($name,$value,$choices);
				break;
				case 'radio':
					$this->make_radio_field($name,$value,$choices);
				break;
				case 'checkbox':
					$this->make_checkbox_field($name,$value,$choices);	
				break;
				case 'hidden':
					$this->make_hidden_field($name,$value);
				break;
			}
		}
	
			function make_text_field($name,$value) {
				echo "\t\t\t" . '<input type="text" name="' . $name . '" id="' . $name . '" value="' . $value . '"';
				echo " />\n";
			}
			
			/**
			 * Generates a textarea input field
			 *
			 * @param string $name The name of the input field
			 * @param string $value The value to set the field to on load
			 * @param int $size Size param to pass to input tag
			 * @param string $args Additional arguments to pass to input tag such as onClick or onChange functions
			 */
			function make_textarea_field($name,$value) {
				echo "\t\t\t" . '<textarea name="' . $name . '" id="' . $name . '"';
				echo '>' . $value . "</textarea>\n";
			}
			
			/**
			 * Generates a select drop-down
			 *
			 * @param string $name The name of the input field
			 * @param string $value The value to set the field to on load
			 * @param array $choices Choices to pass to radio, select, and checkbox inputs
			 * @param string $args Additional arguments to pass to input tag such as onClick or onChange functions
			 */
			function make_select_field($name,$value,$choices) {
				echo "\t\t\t" . '<select name="' . $name . '" id="' . $name . '" ' . ">\n";
				foreach ($choices as $choice=>$desc) {
					echo "\t\t\t\t" . '<option value="' . $choice . '"';
					if ($choice == $value) echo ' selected="true"';
					echo '>' . $desc . "</option>\n";
				}
				echo "\t\t\t" . "</select>\n";
			}
			
			/**
			 * Generates a set of radio inputs
			 *
			 * @param string $name The name of the input field
			 * @param string $value The value to set the field to on load
			 * @param array $choices Choices to pass to radio, select, and checkbox inputs
			 * @param string $args Additional arguments to pass to input tag such as onClick or onChange functions
			 */
			function make_radio_field($name,$value,$choices) {
				foreach ($choices as $choice=>$desc) {
					echo "\t\t\t" . '<input type="radio" name="' . $name . '" id="' . $name . '[' . $choice . ']" ' . " value='" . $choice. "'";
					if ($choice == $value) echo ' checked="true"';
					echo ' /><label for="' . $name . '[' . $choice . ']">' . $desc . "</label><br />\n";
				}
			}
			
			/**
			 * Generates a set of checkboxes
			 *
			 * @param string $name The name of the input field
			 * @param string $value The value to set the field to on load
			 * @param array $choices Choices to pass to radio, select, and checkbox inputs
			 * @param string $args Additional arguments to pass to input tag such as onClick or onChange functions
			 */
			function make_checkbox_field($name,$value,$choices) {
				foreach ($choices as $choice=>$desc) {
					echo "\t\t\t" . '<input type="checkbox" name="' . $name . '[' . $choice . ']" id="' . $name . '[' . $choice . ']" ';
					if ($choice == $value) echo ' checked="checked"';
					echo ' /><label for="' . $name . '[' . $choice . ']">' . $desc . "</label><br />\n";
				}
			}
			
			/**
			 * Generates a hidden field
			 *
			 * @param string $name The name of the input field
			 * @param string $value The value to set the field to
			 */
			function make_hidden_field($name,$value) {
				echo "\t\t\t" . '<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value . '" />' . "\n";
			}

}

new GWHAID;

?>
