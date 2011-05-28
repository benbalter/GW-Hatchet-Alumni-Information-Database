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

	static function test() { echo 'test'; }
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
	
	function field_defaults() {
		return 	array( 
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
    		'choices' => array( 
    		),
   		);	

	}
	
	function fields() {
	
		return array(
		
			'name' => array(
				'label' => '',
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

	function rewrite_rules( $rules ) {
	        
	    $newrules[ 'gwhaid/?$'] = 'index.php?gwhaid=1';
	    return $newrules + $rules;
	
	}

	function template_intercept() {
	 		
	 	global $wp_query;
	 	
	 	if( isset($wp_query->query_vars['gwhaid']) ) {	
	 		
	 		wp_enqueue_script( 'gwhaid', plugins_url( 'js.js', __FILE__ ), array('jquery' ), filemtime( dirname(__FILE__) . '/js.js' ), true );
	 		wp_enqueue_style( 'gwhaid', plugins_url( 'style.css', __FILE__ ) );
	 		
			add_filter( 'template_include', array($this, 'template_filter' ) );
		
		}
	
	}

	function template_filter( $template ) {
		
		return dirname( __FILE__ ) . '/form.php';
		
	}
	
	function query_var( $vars ) {
	
	    $vars[] = "gwhaid";    
	    return $vars;
	
	}


}

new GWHAID;

?>