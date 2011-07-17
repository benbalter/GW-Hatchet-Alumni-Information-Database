<?php get_header(); ?>
<?php
$gwhaid = GWHAID::$instance;
$fields = $gwhaid->fields();

//check to see if we're passed a user, if not assume current user
if ( !$user = get_query_var('user') )
	$user = get_current_user_id();
else
	$user = get_user_by( 'nicename', $get_query_var( 'user' ) );
	
if ( !$user )
	wp_error( '404' );

//get userdata
$userdata = new WP_User( $user );	

//do some stuff here to store the data
if ($_POST) {
	foreach ($fields as $group) {
		foreach ($group['fields'] as $field) {
			update_user_meta( $user, $gwhaid->prefix . $field['name'], sanitize_text_field( $_POST[$field['name']] ) ); 
		}
	}
}
?>
<div id="primary">
<div id="content" role="main">
<h1 class="entry-title">Alumni Information Database</h1>
<form method="post">
<?php

foreach ($fields as $id=>$group) { ?>
	<?php if ( isset( $group['label'] ) && strlen( $group['label'] ) != 0 ) { ?>
		<h3><?php echo $group['label']; ?></h3>
	<?php } ?>
	<div class="<?php echo $group['class']; ?>" id="<?php echo $id; ?>">
	<?php foreach ($group['fields'] as $field) { 
	
		//insert defaults
		$field = wp_parse_args( $field, GWHAID::$instance->field_defaults() );
		
		//check field-level group permissions
		if ( $user != get_current_user_id() && $field['permissions']['global_read'] == false )
			continue; 
		
		//check field-level user permissions
		if ( !current_user_can( 'manage_options' ) && $field['permissions']['user_write'] == false)
			continue;
		
		//build field key
		$key = $gwhaid->prefix . $field['name'];
		
		//check if user has field set, if so, pull into array
		if ( isset( $userdata->$key ) )
			$field['value'] = $userdata->$key;
		
		?>
		<div id="<?php echo $field['name']; ?>">
			<label>
				<span<?php if ($field['required']) echo ' class="required"'; ?>><?php echo $field['label']; ?></span>
				<?php GWHAID::$instance->make_field($field['name'], $field['type'], esc_attr( $field['value'] ), $field['choices'] ); ?>
				<?php if ( $field['multiple'] ) { ?>
					<div class="<?php echo $field['name']; ?> hide-if-js">
						<input type="<?php echo $field['type']; ?>" name="meta[<?php echo $field['name']; ?>[]" />
					</div>
				<?php } ?>
			</label>
		</div>	
	<?php } ?>
	<?php if ( $field['multiple'] ) { ?>
		<p><a href="#" id="<?php echo $id; ?>_add" class="<?php echo $id; ?> add_row">Add</a></p>
	<?php } ?>
 	</div>
<?php } ?>
	<input type="submit" value="Submit" />
</form>
</div>
</div>
<?php get_footer(); ?>