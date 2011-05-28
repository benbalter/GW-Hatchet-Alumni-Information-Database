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

class gwhaid {


	/**
	 * Constructor function for hooks
	 */
	function gwhaid() {
	
	
	
	
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
	
		/**
		 * Permissions
		 * R => Read
		 * W => Write
		 * Admin always has RW
		 */
	
		$fields = array(
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



		);
		
	}

}

$gwhaiud = new gwhaid();

?>