<?php
if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

	/**
	 * This file compiles all emails actions. 
	 * 
	 * The files on the email html template needs to be updated for every single project.
	 *
	 * @category   Themes
	 * @author     Steven Rivera <stevenlrr@gmail.com>
	 * @copyright  2018 VOS Group
	 * @license    http://creativecommons.org/licenses/by-nc-nd/4.0/
	 * @version    1.0.0
	 * @since      File available since 1.0.0
	 * 
	 * @help https://bootstrapemail.com/docs/introduction
	 */
	
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;

	function send_recover_email($to_name, $to_email, $link) {
		$message = "Hi <b>$to_name</b>!<br /><br />";
		$message = $message."You have requested a password reset at <b>".get_setting(12)."</b>.<br /><br />";
		$message = $message."If you didn't perform this action, just ignore this email and the link will expire in 24 hours.<br /><br />";
		$message = $message."To reset your password, click the following link or copy and paste it in your browser: <br /><br /><br /><a href='$link' target='_blank'>$link</a>";	
		
		$subject = "Password Reset";
		$from_email = 'no-reply@'.get_host();
		
		if ( send_email(get_setting(12), $from_email, $to_email, $to_name, $subject, $message) ) {
			return true;
		}
		
		return false;
    }
    
	function support_email ($from_name, $from_email, $subject, $message) {
		
		if ( send_email($from_name, $from_email, get_setting(1), get_setting(12), $subject, $message) ) {
			return true;
		}
		
		return false;
	}
	
	function send_email ($from_name, $from_email, $to_email, $to_name, $subject, $comments, $attachment = '') {
		if ( empty($from_name) or !is_email($from_email) or !is_email($to_email) or empty($subject) or empty($comments) ) {
			return false;
		}
		
		$mail = new PHPMailer;
		$mail->CharSet = 'utf-8';
		
		//Tell PHPMailer to use SMTP
		if ( get_setting(4) == 'true' ) {
			//SMTP needs accurate times, and the PHP time zone MUST be set
			date_default_timezone_set('Etc/UTC');
			$mail->isSMTP();
			
			$mail->SMTPDebug = 0;
			
			//Set the hostname of the mail server
			$mail->Host = get_setting(5);

			//Set the SMTP port number - likely to be 25, 465 or 587
			$mail->Port = get_setting(6);
			
			//TLS Support
			if ( get_setting(7) == 'true' ) {
				$mail->SMTPSecure = 'tls';
			}
			
			//Whether to use SMTP authentication
			if ( !empty(get_setting(8)) && !empty(get_setting(9)) ) {
				$mail->SMTPAuth = true;
				$mail->Username = get_setting(8);
				$mail->Password = get_setting(9);
			}
		}

		$mail->setFrom($from_email, $from_name);
		$mail->addAddress($to_email, $to_name);

		$mail->Subject = $subject;

		$mail->isHTML(true);
		$mail->Body = boostrap_email($subject, $comments);

		//To make ensure that the recipient will be able to read the e-mail, even if their e-mail client doesn't support HTML, we can add a plain-text version of the message
		$mail->AltBody = sanitize_xss($comments);
	
		if ( !empty($attachment) ) {
			$mail->addAttachment($attachment);
		}
		
		if ($mail->send()) {
			return true;
		} 
		
		return false;
	}

	function boostrap_email($subject, $comments) {
		/**
		 * ORIGINAL WHITHOUT COMPILE Boostrap Email Template
         * @https://bootstrapemail.com/editor
         * 
		 * <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		 * <html>
		 * <head>
		 *  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		 *  <link rel="stylesheet" media="all" href="https://renthomebase.nyc3.digitaloceanspaces.com/general/boostrap-email/application-mailer-dbc5154d3c4160e8fa7ef52fa740fa402760c39b5d22c8f6d64ad5999499d263.css" />
		 *  <style>
		 *	   a{ color: #274abb; }
		 *	   a:hover{ color: #000 !important; }
		 *	   a.text-light{ color: #fff !important; }
		 *  </style>
		 * </head>
		 * <!-- Edit the code below this line -->
		 * <body class="bg-light">
		 * <!-- If you aren’t familiar with preview text, it is the text that shows up in your inbox as a preview of the content inside the email. -->
		 * <preview>'.substr(sanitize_xss($comments),0,150).'....</preview>
		 * <div class="container">
		 * <img class="mx-auto mt-4 mb-5" width="165" height="56" src="https://renthomebase.nyc3.digitaloceanspaces.com/general/boostrap-email/homebase-logo-2.png" />
		 *
		 * <div class="card mb-4" style="border-top: 5px solid #274abb;">
		 *	<div class="card-body">
		 *	  <h4 class="text-center mb-2">'.$subject.'</h4>
		 *	  <h5 class="text-muted text-center"></h5>
		 *
		 *	  <hr/>
		 *
		 *	  <p class="text-center mt-2 mb-5">'.$comments.'</p>
		 *	  
		 *	</div>
		 * </div>
		 *
		 * <div class="text-center text-muted"><a href="'.get_actual_url().'/faq">FAQ</a> · <a href="'.get_actual_url().'/submit-property">Submit Property</a></div>
		 *
		 * <table class="table-unstyled text-muted mb-4">
		 *	<tbody>
		 *	  <tr>
		 *		<td>© '.get_setting(12).'</td>
		 *		<td>
		 *		  <a href="'.get_setting(2).'"><img class="float-right pl-2" width="20" height="20" src="https://renthomebase.nyc3.digitaloceanspaces.com/general/boostrap-email/facebook@2x.png"/></a>
		 *		  <a href="'.get_setting(3).'"><img class="float-right" width="20" height="20" src="https://renthomebase.nyc3.digitaloceanspaces.com/general/boostrap-email/instagram@2x.png"/></a>
		 *		</td>
		 *	  </tr>
		 *	</tbody>
		 * </table>
		 *
		 * </div>
		 *
		 * </body>
		 *</html>
		 */

		$html_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>a:hover {
        color: #000 !important;
        }
        </style>        <style type="text/css">
                  .ExternalClass{width:100%}.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:150%}a{text-decoration:none}@media screen and (max-width: 600px){table.row th.col-lg-1,table.row th.col-lg-2,table.row th.col-lg-3,table.row th.col-lg-4,table.row th.col-lg-5,table.row th.col-lg-6,table.row th.col-lg-7,table.row th.col-lg-8,table.row th.col-lg-9,table.row th.col-lg-10,table.row th.col-lg-11,table.row th.col-lg-12{display:block;width:100% !important}.d-mobile{display:block !important}.d-desktop{display:none !important}.w-lg-25{width:auto !important}.w-lg-25>tbody>tr>td{width:auto !important}.w-lg-50{width:auto !important}.w-lg-50>tbody>tr>td{width:auto !important}.w-lg-75{width:auto !important}.w-lg-75>tbody>tr>td{width:auto !important}.w-lg-100{width:auto !important}.w-lg-100>tbody>tr>td{width:auto !important}.w-lg-auto{width:auto !important}.w-lg-auto>tbody>tr>td{width:auto !important}.w-25{width:25% !important}.w-25>tbody>tr>td{width:25% !important}.w-50{width:50% !important}.w-50>tbody>tr>td{width:50% !important}.w-75{width:75% !important}.w-75>tbody>tr>td{width:75% !important}.w-100{width:100% !important}.w-100>tbody>tr>td{width:100% !important}.w-auto{width:auto !important}.w-auto>tbody>tr>td{width:auto !important}.p-lg-0>tbody>tr>td{padding:0 !important}.pt-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-top:0 !important}.pr-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-right:0 !important}.pb-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-bottom:0 !important}.pl-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-left:0 !important}.p-lg-1>tbody>tr>td{padding:0 !important}.pt-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-top:0 !important}.pr-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-right:0 !important}.pb-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-bottom:0 !important}.pl-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-left:0 !important}.p-lg-2>tbody>tr>td{padding:0 !important}.pt-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-top:0 !important}.pr-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-right:0 !important}.pb-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-bottom:0 !important}.pl-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-left:0 !important}.p-lg-3>tbody>tr>td{padding:0 !important}.pt-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-top:0 !important}.pr-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-right:0 !important}.pb-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-bottom:0 !important}.pl-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-left:0 !important}.p-lg-4>tbody>tr>td{padding:0 !important}.pt-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-top:0 !important}.pr-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-right:0 !important}.pb-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-bottom:0 !important}.pl-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-left:0 !important}.p-lg-5>tbody>tr>td{padding:0 !important}.pt-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-top:0 !important}.pr-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-right:0 !important}.pb-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-bottom:0 !important}.pl-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-left:0 !important}.p-0>tbody>tr>td{padding:0 !important}.pt-0>tbody>tr>td,.py-0>tbody>tr>td{padding-top:0 !important}.pr-0>tbody>tr>td,.px-0>tbody>tr>td{padding-right:0 !important}.pb-0>tbody>tr>td,.py-0>tbody>tr>td{padding-bottom:0 !important}.pl-0>tbody>tr>td,.px-0>tbody>tr>td{padding-left:0 !important}.p-1>tbody>tr>td{padding:4px !important}.pt-1>tbody>tr>td,.py-1>tbody>tr>td{padding-top:4px !important}.pr-1>tbody>tr>td,.px-1>tbody>tr>td{padding-right:4px !important}.pb-1>tbody>tr>td,.py-1>tbody>tr>td{padding-bottom:4px !important}.pl-1>tbody>tr>td,.px-1>tbody>tr>td{padding-left:4px !important}.p-2>tbody>tr>td{padding:8px !important}.pt-2>tbody>tr>td,.py-2>tbody>tr>td{padding-top:8px !important}.pr-2>tbody>tr>td,.px-2>tbody>tr>td{padding-right:8px !important}.pb-2>tbody>tr>td,.py-2>tbody>tr>td{padding-bottom:8px !important}.pl-2>tbody>tr>td,.px-2>tbody>tr>td{padding-left:8px !important}.p-3>tbody>tr>td{padding:16px !important}.pt-3>tbody>tr>td,.py-3>tbody>tr>td{padding-top:16px !important}.pr-3>tbody>tr>td,.px-3>tbody>tr>td{padding-right:16px !important}.pb-3>tbody>tr>td,.py-3>tbody>tr>td{padding-bottom:16px !important}.pl-3>tbody>tr>td,.px-3>tbody>tr>td{padding-left:16px !important}.p-4>tbody>tr>td{padding:24px !important}.pt-4>tbody>tr>td,.py-4>tbody>tr>td{padding-top:24px !important}.pr-4>tbody>tr>td,.px-4>tbody>tr>td{padding-right:24px !important}.pb-4>tbody>tr>td,.py-4>tbody>tr>td{padding-bottom:24px !important}.pl-4>tbody>tr>td,.px-4>tbody>tr>td{padding-left:24px !important}.p-5>tbody>tr>td{padding:48px !important}.pt-5>tbody>tr>td,.py-5>tbody>tr>td{padding-top:48px !important}.pr-5>tbody>tr>td,.px-5>tbody>tr>td{padding-right:48px !important}.pb-5>tbody>tr>td,.py-5>tbody>tr>td{padding-bottom:48px !important}.pl-5>tbody>tr>td,.px-5>tbody>tr>td{padding-left:48px !important}.s-lg-1>tbody>tr>td,.s-lg-2>tbody>tr>td,.s-lg-3>tbody>tr>td,.s-lg-4>tbody>tr>td,.s-lg-5>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-0>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-1>tbody>tr>td{font-size:4px !important;line-height:4px !important;height:4px !important}.s-2>tbody>tr>td{font-size:8px !important;line-height:8px !important;height:8px !important}.s-3>tbody>tr>td{font-size:16px !important;line-height:16px !important;height:16px !important}.s-4>tbody>tr>td{font-size:24px !important;line-height:24px !important;height:24px !important}.s-5>tbody>tr>td{font-size:48px !important;line-height:48px !important;height:48px !important}}@media yahoo{.d-mobile{display:none !important}.d-desktop{display:block !important}.w-lg-25{width:25% !important}.w-lg-25>tbody>tr>td{width:25% !important}.w-lg-50{width:50% !important}.w-lg-50>tbody>tr>td{width:50% !important}.w-lg-75{width:75% !important}.w-lg-75>tbody>tr>td{width:75% !important}.w-lg-100{width:100% !important}.w-lg-100>tbody>tr>td{width:100% !important}.w-lg-auto{width:auto !important}.w-lg-auto>tbody>tr>td{width:auto !important}.p-lg-0>tbody>tr>td{padding:0 !important}.pt-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-top:0 !important}.pr-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-right:0 !important}.pb-lg-0>tbody>tr>td,.py-lg-0>tbody>tr>td{padding-bottom:0 !important}.pl-lg-0>tbody>tr>td,.px-lg-0>tbody>tr>td{padding-left:0 !important}.p-lg-1>tbody>tr>td{padding:4px !important}.pt-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-top:4px !important}.pr-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-right:4px !important}.pb-lg-1>tbody>tr>td,.py-lg-1>tbody>tr>td{padding-bottom:4px !important}.pl-lg-1>tbody>tr>td,.px-lg-1>tbody>tr>td{padding-left:4px !important}.p-lg-2>tbody>tr>td{padding:8px !important}.pt-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-top:8px !important}.pr-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-right:8px !important}.pb-lg-2>tbody>tr>td,.py-lg-2>tbody>tr>td{padding-bottom:8px !important}.pl-lg-2>tbody>tr>td,.px-lg-2>tbody>tr>td{padding-left:8px !important}.p-lg-3>tbody>tr>td{padding:16px !important}.pt-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-top:16px !important}.pr-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-right:16px !important}.pb-lg-3>tbody>tr>td,.py-lg-3>tbody>tr>td{padding-bottom:16px !important}.pl-lg-3>tbody>tr>td,.px-lg-3>tbody>tr>td{padding-left:16px !important}.p-lg-4>tbody>tr>td{padding:24px !important}.pt-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-top:24px !important}.pr-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-right:24px !important}.pb-lg-4>tbody>tr>td,.py-lg-4>tbody>tr>td{padding-bottom:24px !important}.pl-lg-4>tbody>tr>td,.px-lg-4>tbody>tr>td{padding-left:24px !important}.p-lg-5>tbody>tr>td{padding:48px !important}.pt-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-top:48px !important}.pr-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-right:48px !important}.pb-lg-5>tbody>tr>td,.py-lg-5>tbody>tr>td{padding-bottom:48px !important}.pl-lg-5>tbody>tr>td,.px-lg-5>tbody>tr>td{padding-left:48px !important}.s-lg-0>tbody>tr>td{font-size:0 !important;line-height:0 !important;height:0 !important}.s-lg-1>tbody>tr>td{font-size:4px !important;line-height:4px !important;height:4px !important}.s-lg-2>tbody>tr>td{font-size:8px !important;line-height:8px !important;height:8px !important}.s-lg-3>tbody>tr>td{font-size:16px !important;line-height:16px !important;height:16px !important}.s-lg-4>tbody>tr>td{font-size:24px !important;line-height:24px !important;height:24px !important}.s-lg-5>tbody>tr>td{font-size:48px !important;line-height:48px !important;height:48px !important}}
        
                </style>
</head>
<!-- Edit the code below this line -->

<body style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; margin: 0; padding: 0; border: 0;">
    <div class="preview" style="display: none; max-height: 0px; overflow: hidden;">
		'.substr(sanitize_xss($comments),0,150).'...
    </div>
    <table valign="top" class="bg-light body" style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; margin: 0; padding: 0; border: 0;" bgcolor="#f8f9fa">
        <tbody>
            <tr>
                <td valign="top" style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; margin: 0;" align="left" bgcolor="#f8f9fa">

                    <!-- If you aren’t familiar with preview text, it is the text that shows up in your inbox as a preview of the content inside the email. -->

                    <table class="container" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%;">
                        <tbody>
                            <tr>
                                <td align="center" style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; margin: 0; padding: 0 16px;">
                                    <!--[if (gte mso 9)|(IE)]>
          <table align="center">
            <tbody>
              <tr>
                <td width="600">
        <![endif]-->
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; max-width: 600px; margin: 0 auto;">
                                        <tbody>
                                            <tr>
                                                <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; margin: 0;" align="left">

                                                    <table class="mx-auto" align="center" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; margin: 0 auto;">
                                                        <tbody>
                                                            <tr>
                                                                <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; margin: 0;" align="left">
                                                                    <table class="s-4 w-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td height="24" style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;" align="left">

                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>

                                                                    <img class="  " width="165" height="56" src="https://renthomebase.nyc3.digitaloceanspaces.com/general/boostrap-email/homebase-logo-2.png" style="height: auto; line-height: 100%; outline: none; text-decoration: none; border: 0 none;">
                                                                    <table class="s-5 w-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td height="48" style="border-spacing: 0px; border-collapse: collapse; line-height: 48px; font-size: 48px; width: 100%; height: 48px; margin: 0;" align="left">

                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>

                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <table class="card " border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: separate !important; border-radius: 4px; width: 100%; overflow: hidden; border: 1px solid #dee2e6;" bgcolor="#ffffff">
                                                        <tbody>
                                                            <tr>
                                                                <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left">
                                                                    <div style="border-top-width: 5px; border-top-color: #274abb; border-top-style: solid;">
                                                                        <table class="card-body" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%;">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; width: 100%; margin: 0; padding: 20px;" align="left">
                                                                                        <div>
                                                                                            <h4 class="text-center " style="margin-top: 0; margin-bottom: 0; font-weight: 500; color: inherit; vertical-align: baseline; font-size: 24px; line-height: 28.8px;" align="center">'.$subject.'</h4>
                                                                                            <table class="s-2 w-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td height="8" style="border-spacing: 0px; border-collapse: collapse; line-height: 8px; font-size: 8px; width: 100%; height: 8px; margin: 0;" align="left">

                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>

                                                                                            <h5 class="text-muted text-center" style="margin-top: 0; margin-bottom: 0; font-weight: 500; color: #636c72; vertical-align: baseline; font-size: 20px; line-height: 24px;" align="center"></h5>

                                                                                            <div class="hr " style="width: 100%; margin: 20px 0; border: 0;">
                                                                                                <table border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%;">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; border-top-width: 1px; border-top-color: #dddddd; border-top-style: solid; height: 1px; width: 100%; margin: 0;" align="left"></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>

                                                                                            <table class="s-2 w-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td height="8" style="border-spacing: 0px; border-collapse: collapse; line-height: 8px; font-size: 8px; width: 100%; height: 8px; margin: 0;" align="left">

                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>

                                                                                            <p class="text-center  " style="line-height: 24px; font-size: 16px; margin: 0;" align="center">'.$comments.'</p>
                                                                                            <table class="s-5 w-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td height="48" style="border-spacing: 0px; border-collapse: collapse; line-height: 48px; font-size: 48px; width: 100%; height: 48px; margin: 0;" align="left">

                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>

                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>

                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="s-4 w-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                                        <tbody>
                                                            <tr>
                                                                <td height="24" style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;" align="left">

                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <div class="text-center text-muted" style="color: #636c72;" align="center">
                                                        <a href="'.get_actual_url().'/faq" style="color: #274abb;">FAQ</a> · <a href="'.get_actual_url().'/submit-property" style="color: #274abb;">Submit Property</a>
                                                    </div>

                                                    <table class="table-unstyled text-muted " border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse; width: 100%; max-width: 100%; color: #636c72;" bgcolor="transparent">
                                                        <tbody>
                                                            <tr>
                                                                <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; border-top-width: 0; border-bottom-width: 0; margin: 0;" align="left">© '.get_setting(12).'</td>
                                                                <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; border-top-width: 0; border-bottom-width: 0; margin: 0;" align="left">
                                                                    <a href="'.get_setting(2).'" style="color: #274abb;">
                                                                    <table class="float-right" align="right" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; border-top-width: 0; border-bottom-width: 0; margin: 0;" align="left">
                                                                                    <table class="pl-2" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse;">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; border-top-width: 0; border-bottom-width: 0; padding-left: 8px; margin: 0;" align="left">
                                                                                                    <img class=" " width="20" height="20" src="https://renthomebase.nyc3.digitaloceanspaces.com/general/boostrap-email/facebook@2x.png" style="height: auto; line-height: 100%; outline: none; text-decoration: none; border: 0 none;">
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>

                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    </a>

                                                                    <a href="'.get_setting(3).'" style="color: #274abb;">
                                                                    <table class="float-right" align="right" border="0" cellpadding="0" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-spacing: 0px; border-collapse: collapse;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 16px; border-top-width: 0; border-bottom-width: 0; margin: 0;" align="left">
                                                                                    <img class="" width="20" height="20" src="https://renthomebase.nyc3.digitaloceanspaces.com/general/boostrap-email/instagram@2x.png" style="height: auto; line-height: 100%; outline: none; text-decoration: none; border: 0 none;">
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    </a>

                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="s-4 w-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                                        <tbody>
                                                            <tr>
                                                                <td height="24" style="border-spacing: 0px; border-collapse: collapse; line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;" align="left">

                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--[if (gte mso 9)|(IE)]>
                </td>
              </tr>
            </tbody>
          </table>
        <![endif]-->
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>';

		return $html_template;
	}
?>