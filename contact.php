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
	$error = 'Debes introducir tu nombre.';
}
////////////////////////


////////////////////////
// Email field is required
if(empty($email)) {
	$error = 'Por favor, introduzca una dirección de correo electrónico válida.';
} else if(!is_email($email)) {
	$error = 'Ha introducido una dirección de correo electrónico inválida, inténtelo de nuevo.';
}
////////////////////////


////////////////////////
// Subject field is required
if(empty($subject)) {
	$error = 'Por favor, introduzca un tema.';
}
////////////////////////


////////////////////////
// Comments field is required
if(empty($comments)) {
	$error = 'Por favor, introduzca su mensaje.';
}
////////////////////////

////////////////////////
// Bot Detection Field
if(!empty($important)) {
	$error = 'Por favor, inténtelo de nuevo más tarde.';
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

 $e_person = "";
 $referral = get_referral_cookie();

 if($referral) {
	$e_person = "Our system detects that {$referral[0]} with the referral id of '{$referral[1]}' recommended a property on Homebase to $name <br /><br />";
 }
 elseif (!empty($person)) {
 	$e_person = "$person recommended a property on Homebase to $name <br /><br />";
 }

 $e_content = $comments." <br /><br />";
 $e_reply = "You can contact $name via email at: $email or simply reply to this message.";

 $msg = $e_person . $e_content . $e_reply;

 if( support_email($name, $email, $e_subject, $msg)) {
	 //The file custom.js is using the keyword "submitted" or "enviado" on the message text to let know js that the message was successfully sent and close the form
	 //If you intent on changing it, remember to also change it on /views/assets/scripts/custom.js for proper functioning
	 echo "<div class='contact-sent'>Gracias <strong>$name</strong>, su mensaje fue enviado.</div>";
 } 
 else {
	 echo "<div class='notification error'>Se produjo un error al enviar el mensaje. Por favor, inténtelo de nuevo más tarde, o póngase en contacto con nosotros por correo electrónico.</div>";
 }

 ///////////////////////////////////////////////////////////////////////////
?>