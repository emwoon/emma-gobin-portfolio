<?php
class PHP_Email_Form {
  public $to;
  public $from_name;
  public $from_email;
  public $subject;
  public $smtp;
  public $ajax;
  public $message;

  public function __construct() {
    $this->message = [];
  }

  public function add_message( $input, $type, $length = null ) {
    if($length !== null) {
      $this->message[$type] = substr($input, 0, $length);
    } else {
      $this->message[$type] = $input;
    }
  }

  public function send() {
    if($this->smtp) {
      // Using SMTP
      require 'PHPMailer/PHPMailerAutoload.php';
      $mail = new PHPMailer;
      $mail->isSMTP();
      $mail->Host = $this->smtp['host'];
      $mail->SMTPAuth = true;
      $mail->Username = $this->smtp['username'];
      $mail->Password = $this->smtp['password'];
      $mail->Port = $this->smtp['port'];

      $mail->setFrom($this->from_email, $this->from_name);
      $mail->addAddress($this->to);
      $mail->Subject = $this->subject;
      $mail->Body = implode("\r\n", $this->message);

      if(!$mail->send()) {
        return 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
      } else {
        return 'Message has been sent';
      }
    } else {
      // Using mail()
      $headers = "From: $this->from_name <$this->from_email>" . "\r\n";
      $message = implode("\r\n", $this->message);

      if(mail($this->to, $this->subject, $message, $headers)) {
        return 'Message has been sent';
      } else {
        return 'Message could not be sent.';
      }
    }
  }
}
?>
