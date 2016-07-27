<?php

namespace DelejCoUmis\Emails;

use Nette;


class ContactEmailFactory
{

	public function create($name, $email, $phone = NULL, $linkedIn = NULL, $additional = NULL, Nette\Http\FileUpload $cv = NULL)
	{
		$message = new Nette\Mail\Message();

		$subject = 'Zájemce PHP/Nette programátor';

		$message->addTo('jobs@peckadesign.cz');
		$message->setFrom($email, $name);
		$message->setSubject($subject);

		$body = "$subject\n";
		$body .= "Jméno: $name\n";
		$body .= "E-mail: $email\n";
		if ($phone) {
			$body .= "Telefon: $phone\n";
		}

		if ($linkedIn) {
			$body .= "LinkedIn: $linkedIn\n";
		}
		if ($additional) {
			$body .= "\n$additional";
		}

		$message->setBody($body);

		if ($cv && $cv->isOk()) {
			$message->addAttachment($cv->getSanitizedName(), $cv->getContents(), $cv->getContentType());
		}
		
		return $message;
	}
}
