<?php 
wp_enqueue_script('jquery');
get_header(); 
$fields = GWHAID::$instance->fields();
foreach ($fields as $id=>$group) { ?>
	<?php if ( isset( $group['label'] ) && strlen( $group['label'] ) != 0 ) { ?>
		<h3><?php echo $group['label']; ?></h3>
	<?php } ?>
	<div class="<?php echo $group['class']; ?>" id="<?php echo $id; ?>">
	<?php foreach ($group['fields'] as $field) { ?>
		<div>
			<label>
				<span<?php if ($field['required']) echo ' class="required"'; ?>><?php echo $field['label']; ?></span>
				<input type="<?php echo $field['type']; ?>" name="meta[<?php echo $field['name']; ?>" />
			</label>
		</div>	
	<?php } ?>
 	</div>
<?php } ?>

<div class="form-group names">
	<div><label><span>Last Name</span> <input type="text" name="meta[last_name]" /></label></div>
	<div><label><span>Maiden Name</span> <input type="text" name="meta[maiden_name]" /></label></div>
</div>
<div class="form-group emails">
	<div><label><span>Email Address</span> <input type="text" name="meta[email_address]" /></label></div>
	<div><label><span>Secondary Email</span> <input type="text" name="meta[secondary_email]" /></label></div>
</div>

<div class="form-group year">
	<div><label><span>Grad Year</span> <input type="text" name="meta[grad_year]" /></label></div>
</div>

<div id="positions">
	<div class="position"><input type="text" name="meta[hatchet_position][]" /></div>
	<div class="position hide-if-js"><input type="text" name="meta[hatchet_position][]" /></div>
</div>

<h3>Employers</h3>
<div id="employers">
	<div class="employer">
		<label><span>Employer</span> <input type="text" name="meta[employer][][employer]" /></label><br />
		<label><span>Position</span> <input type="text" name="meta[employer][][position]" /><br />
		<label><span><input type="checkbox" name="meta[employer][][work_here]" /></span> I currently work here</label>
	</div>
</div>
<p><a href="#" id="employer_add" class="employer add_row">Add</a></p>


<h3>Contact Information</h3>
<p class="phone"><label><span>Phone Number</span> <input type="text" name="meta[phone]" /></label></p>
<p class="address"><label><span>Address</span> <input type="text" name="meta[address]" /></label><br/>
	<span></span> <input type="text" name="meta[address_2]" /></p>
<p class="city"><label><span>City</span> <input type="text" name="meta[city]" /></label></p>
<p class="state"><label><span>State</span> <input type="text" name="meta[state]" /></label></p>
<p class="country"><label><span>Country</span> <select name="meta[country]"><option>United States</option></select></label></p>
<p class="zip"><label><span>Zip</span> <input type="text" name="meta[zip]" /></label></p>
<p class="twitter"><label><span>Twitter</span> <input type="text" name="meta[twitter]" /></label></p>

<h3>Internal Data</h3>
<p><label><span>GWID</span> <input type="text" name="meta[gwid]" /></label></p>
<?php get_footer(); ?>