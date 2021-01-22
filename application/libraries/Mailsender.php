<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailsender
{
	private $ci = null;
	public $settings;

	public function __construct()
	{
		$this -> ci =& get_instance();
		$this -> ci -> load -> model('common_model', 'common');
		$this->settings= $this->ci->common->selectOne(['pk' => 1], 'settings');
		print_r($this->settings);
	}

	public function sendmail($to = [])
	{
		$mail = new PHPMailer(true);

		try {
			//Server settings
			$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
			$mail->isSMTP();                                            // Send using SMTP
			$mail->Host = $this->settings->host;                    // Set the SMTP server to send through
			$mail->SMTPAuth = true;                                   // Enable SMTP authentication
			$mail->Username = $this->settings->mailaddress;                     // SMTP username
			$mail->Password = $this->settings->password;                               // SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
			$mail->Port = $this->settings->port;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
			$mail->SMTPAutoTLS = $this->settings->istls;

			//Recipients
			$mail->setFrom($this->settings->mailaddress, 'Bertuğ Fahri ÖZER');
			if (count($to) > 1) {
				foreach ($to as $item) {
					$mail->addAddress($item, 'Abonelik');
				}
			} else
				$mail->addAddress($to[0], 'Abonelik');

			// Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = 'Here is the subject';
			$mail->Body = 'This is the HTML message body <b>in bold!</b>';
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			$mail->send();
			return true;
		} catch (Exception $e) {
			return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
}
