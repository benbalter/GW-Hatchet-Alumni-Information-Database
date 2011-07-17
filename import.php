<!--

Make Chrome FLUSH!!!!! WHOOOSHHHHH!

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur elementum libero nec orci pulvinar iaculis. Vivamus placerat convallis ultricies. Nullam at purus at ante luctus tempor vel molestie dui. Nulla facilisi. Vivamus risus risus, blandit ut sollicitudin eu, adipiscing ac metus. Integer risus est, luctus ut pretium id, iaculis eget neque. Nunc imperdiet sem quis lorem suscipit sollicitudin. Vivamus ipsum risus, pulvinar sodales vulputate vel, vestibulum quis ipsum. Quisque placerat justo id nulla feugiat aliquet. Sed malesuada augue tristique orci imperdiet eu sollicitudin tortor tempor. Proin at velit nibh, vitae accumsan nunc. Phasellus pellentesque nunc ut nisl vulputate scelerisque quis a elit. Quisque eget ullamcorper nunc. Donec eu tortor enim, id varius lectus. Pellentesque aliquam rutrum nibh ut consequat. Ut sed urna eu leo aliquet aliquet et a justo. In hac habitasse platea dictumst. Integer id erat lorem, sed dictum odio. Nullam consequat nisl nec nunc pharetra non hendrerit neque sagittis.

Phasellus hendrerit mollis nunc eget pulvinar. Pellentesque augue ante, laoreet et elementum ut, vulputate quis lacus. Aenean in pretium felis. Etiam vitae arcu nunc, non scelerisque felis. Nam ornare dignissim nunc, sit amet interdum erat tincidunt non. Donec semper massa nec enim varius varius nec in nulla. Nunc facilisis mi eu eros facilisis ut ultricies enim adipiscing. Maecenas ut ipsum velit. In placerat enim et mi congue vulputate in eget nisl. Aenean erat metus, mattis eu venenatis cursus, dapibus sit amet urna. Proin vitae neque lectus, sed ornare nulla. Cras nisl nisl, malesuada sit amet egestas a, elementum ut purus. Pellentesque posuere augue eu urna suscipit commodo. Duis dictum viverra ultricies. Mauris sit amet accumsan massa. In blandit placerat leo ut consequat. Suspendisse tempus, ante at gravida aliquam, metus mauris aliquam mauris, et dictum nibh erat non orci. Duis eu ipsum ut risus aliquam pharetra a id massa.

Etiam et lorem sit amet tellus consectetur fringilla. Curabitur ornare nibh at arcu malesuada convallis. Proin eu ipsum in lorem sollicitudin rhoncus. Sed vehicula nibh ut risus luctus vitae iaculis mi cursus. Nunc varius malesuada turpis consequat gravida. Donec facilisis metus vel velit ornare in commodo nisi mattis. Mauris imperdiet sapien a purus luctus mattis. Fusce gravida bibendum sem aliquam tempor. Pellentesque luctus turpis risus, elementum semper magna. Sed ut mi quis quam adipiscing convallis sit amet vitae orci. Curabitur eu lacinia tortor. Pellentesque adipiscing magna quis nisl porta dapibus consectetur erat dignissim. Vivamus et orci at velit adipiscing mattis ac eu nisi. Sed volutpat, sem vitae euismod dignissim, odio ligula molestie dui, quis tincidunt erat mauris id purus. Aliquam sed elit diam.

In hac habitasse platea dictumst. In venenatis posuere risus, vel varius orci faucibus eu. In eget erat ut dolor hendrerit eleifend vitae quis leo. Integer nec consequat nulla. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam eros justo, euismod vitae blandit sit amet, accumsan quis urna. Nulla eros justo, condimentum a laoreet et, sodales ac enim. Vestibulum semper consectetur tellus, id molestie nulla bibendum non. Maecenas facilisis consequat metus ut vehicula. Duis euismod, quam non pellentesque elementum, libero nunc commodo leo, sit amet molestie nulla lorem id sem. Phasellus eu lectus ut dui accumsan elementum quis id nibh. Duis pellentesque laoreet justo, accumsan scelerisque magna imperdiet eu. Nunc massa quam, luctus et vulputate in, consequat quis nisi.

Cras sapien lectus, ultrices eu dictum sed, semper sit amet risus. Aliquam erat volutpat. Donec vulputate ultrices dignissim. Pellentesque aliquet est eu quam commodo ullamcorper. Mauris dui odio, pellentesque in luctus in, convallis et nulla. Vivamus varius felis sit amet lectus sodales feugiat ut faucibus turpis. Duis fermentum adipiscing mi et vulputate. Fusce malesuada pulvinar libero sed sodales. Nullam non dui nisl. Quisque ultricies condimentum lacus eu blandit. Cras bibendum adipiscing ullamcorper. Vivamus rhoncus turpis ut quam pulvinar cursus.

--><PRE>
<?php

//This file requires import.csv, the export from the google doc in the same folder

echo "Starting Import at " . date('H:i:s') . "\n\n";

include( '../../../wp-load.php');

error_reporting( E_ALL );
set_time_limit( 0 );

$prefix = 'gwhaid_';
$data = array();
$fields = array();

//CSV field => DB usermeta pre prefix
$field_map = array (
  'First Name' => 'fname',
  'Middle Name' => 'mname',
  'Last Name' => 'lname',
  'Hatchet Position' => 'hatchet_position',
  'Graduation Year' => 'grad_year',
  's' => 'email',
  'Secondary email' => 'email2',
  'Job Title' => 'position',
  'Company Name' => 'employer',
  'Home Phone' => 'phone',
  'Work Phone' => 'work_phone', //make me
  'Address Line 1' => 'address',
  'Address Line 2' => 'address2', //make me
  'City' => 'city',
  'US State/CA Province' => 'state',
  'Zip/Postal Code' => 'zip',
  'Country' => 'country',
  'GWID' => 'gwid',
  'Metro Area' => 'metro_area', //make me
);

//move data into an array
if (($handle = fopen("import.csv", "r")) !== FALSE) {
    while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
    	
    	//set first row as fields
    	if ( sizeof( $fields ) == 0) {
    		$fields = $row;
    		continue;
    	}
    	
    	$user = array();
    	
 		//loop through each field and key to an array
    	foreach ( $fields as $num => $label ) {
    		if ( isset( $row[ $num ] ) )
    			$user[ $label ] = $row[ $num ];
    	} 
    
		$data[] = $user;
    }
    fclose($handle);
}

$i=0;
$name_conflicts = 0;
$email_conflict = 0;

//loop through data and import
foreach ( $data as $field => $d ) {
	
	//set login as first initial last name
	$login = strtolower( substr($d['First Name'],0,1) . $d['Last Name'] );

	//check for domain, if not assume GW
	if ( substr($d['s'], -1) == '@' )
		$d['s'] .= 'gwu.edu';
		
	//if no name, call them e-mail
	if ( $login == '' )
		$login = $d['s'];
	
	//check to see if that conflicts
	if ( get_user_by( 'login', $login ) ) {
		
		echo "\n!!! login name $login CONFLICTS... using " .  strtolower( $d['First Name'] . '.' . $d['Last Name'] ) . " instead\n"; flush();
		
		$login = strtolower( $d['First Name'] . '.' . $d['Last Name'] );
		
		$name_conflicts++;

	}
	
	if ( $login == '' || $d['s'] == '' )
		continue;

	if ( get_user_by('email', $d['s'] ) ) {		
		echo "\n!!! E-mail address " . $d['s'] . " CONFLICTS\n"; flush();
		continue;
	}
	
	//build user array
	$user = array( 
		'user_login' => $login,
		'user_nicename' => $login,
		'user_pass' => md5( time() ),
		'user_email' => $d['s'],
		'first_name' => $d['First Name'],
		'last_name' => $d['Last Name'],
		'role' => 'alumni',
	);
	
	//insert user
	$id = wp_insert_user( $user );
	
	if ( is_wp_error( $id ) ) {
		echo "\n!!!" .  $id->get_error_message() . "\n";
		echo "Here's what we tried to import:\n";
		print_r( $user );
		$email_conflicts++;
	}
	
	//loop through fields and add meta
	foreach ( $field_map as $csv_field => $db_field ) {
		if ( isset( $d[ $csv_field ] ) ) 
			add_user_meta( $id, $prefix . $db_field, $d[ $csv_field ], true );
	}
	
	//add a flag to keep nacin happy
	add_user_meta( $id, $prefix . 'import', date('Y-m-d H:i:s' ), true );
	
	//echo "Added $login to the DB\n"; flush();
	$i++;
}

echo "\n\nFinished import at " . date('H:i:s') . "\n\n";

echo "\n\n$i users added!";

echo "\n\n$name_conflicts name conflicts detected (users probably imported)";

echo "\n\n$email_conflicts e-mail conflicts detected (users not imported)";

?>