<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\User;

class MailerService
{
    private $mailer;	 //Swift_Mailer instance
	private $templating; //to render the HTML Template
	private $message;	 //mail instance	

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating, String $mailerSender)
    {
        $this->mailer = $mailer;
		$this->templating = $templating;
		$this->message = (new \Swift_Message())
						->setFrom($mailerSender);
    }
	
    public function createEmailAndSendTo(String $context, User $user)
    {
		$message=$this->message
			->setTo($user->getEmail());

		switch ($context) {
			case "accountCreation":
				$emailTitle = "Merci pour la création de votre compte";
				$emailTemplate = 'emails/registration.html.twig';
				break;
			// case "passwordForgotten":
				// break;
		}
		
		$message->setSubject($emailTitle)
				->setBody(
					$this->templating->render(
						$emailTemplate,
						array('user' => $user)
					),
					'text/html'
				);	
				
		return $this->mailer->send($message);
    }
	
}