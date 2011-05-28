<?php get_header(); ?>
<div id="primary">
<div id="content" role="main">
<h1 class="entry-title">Alumni Information Database</h1>
<?php
$fields = GWHAID::$instance->fields();

foreach ($fields as $id=>$group) { ?>
	<?php if ( isset( $group['label'] ) && strlen( $group['label'] ) != 0 ) { ?>
		<h3><?php echo $group['label']; ?></h3>
	<?php } ?>
	<div class="<?php echo $group['class']; ?>" id="<?php echo $id; ?>">
	<?php foreach ($group['fields'] as $field) { 
	
		//insert defaults
		$field = wp_parse_args( $field, GWHAID::$instance->field_defaults() );
		
		//check field-level permissions
		if ( $field['permissions']['global_read'] == false )
			continue; 
		?>
		<div id="<?php echo $field['name']; ?>">
			<label>
				<span<?php if ($field['required']) echo ' class="required"'; ?>><?php echo $field['label']; ?></span>
				<?php GWHAID::$instance->make_field($field['name'], $field['type'], $field['value'], $field['choices'] ); ?>
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
</div>
</div>
<?php get_footer(); ?>