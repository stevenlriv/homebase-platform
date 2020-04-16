<?php if (!isset($_SESSION)) session_start();

if(!$_POST) exit( header('Location: /not-found') );

define('SCRIP_LOAD', true);

require __DIR__ . '/includes/configuration.php';
require __DIR__ . '/includes/lib.php';

///////////////////////////////////////////////////////////////////////////
//
// Do not edit the following lines
//
///////////////////////////////////////////////////////////////////////////

$postValues = array();
foreach ( $_POST as $name => $value ) {
	$postValues[$name] = sanitize_xss($value);
}
extract( $postValues );

// Important Variables
$posted_verify = isset( $postValues['verify'] ) ? md5( $postValues['verify'] ) : '';
$session_verify = !empty($_SESSION['jigowatt']['html5-contact-form']['verify']) ? $_SESSION['jigowatt']['html5-contact-form']['verify'] : '';

$error = '';

///////////////////////////////////////////////////////////////////////////
//
// Begin verification process
//
// You may add or edit lines in here.
//
// To make a field not required, simply delete the entire if statement for that field.
// You will also have to remove required="required" from the input field, on index.html.
//
///////////////////////////////////////////////////////////////////////////


////////////////////////
// Name field is required
if(empty($name)) {
	$error = 'You must enter your name.';
}
////////////////////////


////////////////////////
// Email field is required
if(empty($email)) {
	$error = 'Please enter a valid email address.';
} else if(!is_email($email)) {
	$error = 'You have enter an invalid e-mail address, try again.';
}
////////////////////////


////////////////////////
// Subject field is required
if(empty($subject)) {
	$error = 'Please enter a subject.';
}
////////////////////////


////////////////////////
// Comments field is required
if(empty($comments)) {
	$error = 'Please enter your message.';
}
////////////////////////

////////////////////////
// Bot Detection Field
if(!empty($important)) {
	$error = 'Please try again later.';
}
////////////////////////

// End verification.
///////////////////////////////////////////////////////////////////////////

if (!empty($error)) {
	echo '<div class="notification error">' . $error . '</div>';
	exit;
}

//////////////////////////////////////////////////////////////////////////


////////////////////////
// Email Compilation

 $e_subject = "$name has contacted about $subject";

 $e_content = $comments." <br /><br />";
 $e_reply = "You can contact $name via email at: $email or simply reply to this message.";

 $msg = $e_content . $e_reply;

 if( _email($name, $email, $e_subject, $msg)) {
	 //The file custom.js is using the keyword "submitted" to let know js that the message was successfully sent and close the form
	 //If you intent on changing it, remember to also change it on /views/assets/scripts/custom.js for proper functioning
	 echo "<div class='contact-sent'>Thank you <strong>$name</strong>, your message has been submitted to us.</div>";
 } 
 else {
	 echo "<div class='notification error'>An error occurred while sending the message. Please try again later, or contact us by email.</div>";
 }

 ///////////////////////////////////////////////////////////////////////////
?>