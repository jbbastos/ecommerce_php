<?php
namespace Hcode;
use Rain\Tpl;

class Mailer
{
    const USERNAME = "jessicabarros@gmail.com";
    const PASSWORD = "22052003"; // ALTERAR A SENHA QUANDO FOR TESTAR
    const NAME_FROM = "Hcode Store";
    
    private $mail;
    
    public function __construct($toAddress, $toName, $subject, $tplName, $data = array())
    {
        $config = array(
            "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/email/",
            "cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
            "debug"         => false // set to false to improve the speed
        );
        
        Tpl::configure( $config );
        
        // create the Tpl object
        $tpl = new Tpl;
        
        foreach ($data as $key => $value)
        {
            $tpl->assign($key, $value);
        }
        
        $html = $tpl->draw($tplName, true);
        
        $this->mail = new \PHPMailer();
        
        $this->mail->isSMTP();
        
        $this->mail->SMTPDebug = 0;
        
        $this->mail->Debugoutput = 'html';
        
        $this->mail->Host = 'smtp.gmail.com';
        
        $this->mail->Port = 587;
        
        $this->mail->SMTPSecure = 'tls';
                       
        $this->mail->SMTPAuth = true;
        
        $this->mail->Username = Mailer::USERNAME;
        
        $this->mail->Password = Mailer::PASSWORD;
        
        $this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);
        
        $this->mail->addAddress($toAddress, $toName);
        
        $this->mail->Subject = $subject;
        
        $this->mail->msgHTML($html);
        
        $this->mail->AltBody = '';  
        
        $this->mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        
    }
    
    public function send()
    {
        if(!$this->mail->send())
        {
            echo "Mailer Error: " . $this->mail->ErrorInfo;
        }
        else
        {
            echo "Message sent";
        }
    }
    
}

