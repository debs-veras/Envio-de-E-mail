<?php
  require "../PHPMailer/src/Exception.php";
  require "../PHPMailer/src/PHPMailer.php";
  require "../PHPMailer/src/OAuth.php";
  require "../PHPMailer/src/POP3.php";
  require "../PHPMailer/src/SMTP.php";
  
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  use PHPMailer\PHPMailer\SMTP;

  class Mensagem{
    private $destinatario;
	private $assunto;
	private $mensagem;
      
	function __construct(){
	  $this->__set('detinatario', NULL);
	  $this->__set('assunto', NULL);
	  $this->__set('mensagem', NULL);
	}
	public function __get($attr){
		return $this->$attr;
	}

	public function __set($attr, $valor){
	  $this->$attr = $valor;
	}

	public function mensagemValida(){
      if(empty($this->__get('destinatario')) || empty($this->__get('assunto')) || empty($this->__get('mensagem'))){
        return false;
	  }
	  return true;
	}
  }

  $mensagem = new Mensagem();
  $mensagem->__set('destinatario', $_POST['para']);
  $mensagem->__set('assunto', $_POST['assunto']);
  $mensagem->__set('mensagem', $_POST['mensagem']);
  print_r($mensagem);
  if(!$mensagem->mensagemValida())
    die();
  $mail = new PHPMailer(true);
  try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'deborahellenvp@gmail.com';                     //SMTP username
    $mail->Password   = 'YP7L1QDE@';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('deboraveras2014ips@gmail.com', 'Debora Hellen');
    $mail->addAddress($mensagem->__get('destinatario'));     //Add a recipient
    
    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $mensagem->__get('assunto');
    $mail->Body    = $mensagem->__get('mensagem');
    $mail->AltBody = 'conteudo apenas com suporte html';
    $mail->send();
    echo 'Messagem enviada com sucesso';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
