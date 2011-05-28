<!doctype html>
<html>
<head>
<style>
span { display: inline-block; width: 150px }
div.form-group { margin: 15px 0 }
div.names input { width: 150px }
div.emails input { width: 200px }
p.year input { width: 50px }
p.zip input { width: 75px }
p.twitter input { width: 100px }
p.address input,
p.city input { width: 150px }
p.phone input { width: 100px }
p.positions input { width: 150px }
span input { margin-left: 135px }

body.js .hide-if-js { display: none }
</style>
<script src="http://localhost/beta/wp-includes/js/jquery/jquery.js"></script>
<script>
(function($){
	$(document).ready( function() {

	});
})(jQuery);
</script>
</head>
<body class="js">

<div class="form-group names">
	<div><label><span>First Name</span> <input type="text" name="meta[first_name]" /></label></div>
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

<h3>Hatchet Positions</h3>
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

</body>
</html>