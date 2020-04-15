<?php
if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

	/**
	 * This file compiles all emails actions
	 *
	 * @category   Themes
	 * @author     Steven Rivera <stevenlrr@gmail.com>
	 * @copyright  2018 VOS Group
	 * @license    http://creativecommons.org/licenses/by-nc-nd/4.0/
	 * @version    1.0.0
	 * @since      File available since 1.0.0
	 */
	
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;

	function _email ($from_name, $from_email, $subject, $message) {
		
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
		
		// SMTP
		if ( get_setting(4) == 'true' ) {
			//SMTP needs accurate times, and the PHP time zone MUST be set
			date_default_timezone_set('Etc/UTC');
			$mail->isSMTP();
			
			$mail->SMTPDebug = 0;
			
			$mail->Host = get_setting(5);
			$mail->Port = get_setting(6);
			
			if ( get_setting(7) == 'true' ) {
				$mail->SMTPSecure = 'tls';
			}
			
			if ( !empty(get_setting(8)) && !empty(get_setting(9)) ) {
				$mail->SMTPAuth = true;
				$mail->Username = get_setting(8);
				$mail->Password = get_setting(9);
			}
		}

		$mail->setFrom($from_email, $from_name);
		$mail->addAddress($to_email, $to_name);

		$mail->Subject = $subject;
		$mail->msgHTML($comments);
	
		if ( !empty($attachment) ) {
			$mail->addAttachment($attachment);
		}
		
		if ($mail->send()) {
			return true;
		} 
		
		return false;
	}
?>