<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\User;

class MailGenerator
{
    private $mailer;
	private $templating; //to render the HTML Template
	private $message;	 //mail instance	

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating, ContainerInterface $container)
    {
        $this->mailer = $mailer;
		$this->templating = $templating;
		// Getting the default sender
		$sender = $container->getParameter('mailer.sender');
		$this->message = (new \Swift_Message())
						->setFrom($sender);
    }
	
    public function createMailAndSendTo(String $mailContext, User $user)
    {
		$message=$this->message
			->setTo($user->getEmail());

		switch ($mailContext) {
			case "accountCreation":
				$emailTitle = "Merci pour la création de votre compte";
				$emailTemplate = 'emails/registration.html.twig';
				break;
			case "passwordForgotten":
				break;
		}
		
		$message->setSubject($emailTitle)
				->setBody(
					$this->templating->render(
						$emailTemplate,
						array('user' => $user)
					),
					'text/html'
				)
				;	
		$this->mailer->send($message);		
		return $this;
    }
	
}