<?php

namespace DelejCoUmis\Controls\Contact;

use DelejCoUmis;
use Nette;
use Tracy;


class ContactControl extends Nette\Application\UI\Control
{

	/**
	 * @var DelejCoUmis\Emails\ContactEmailFactory
	 */
	private $contactEmailFactory;

	/**
	 * @var Nette\Mail\IMailer
	 */
	private $mailer;

	/**
	 * @var DelejCoUmis\Controls\FlashMessages\IFlashMessagesControlFactory
	 */
	private $flashMessagesControlFactory;

	/**
	 * @var Tracy\ILogger
	 */
	private $logger;


	public function __construct(
		DelejCoUmis\Emails\ContactEmailFactory $contactEmailFactory,
		Nette\Mail\IMailer $mailer,
		DelejCoUmis\Controls\FlashMessages\IFlashMessagesControlFactory $flashMessagesControlFactory,
		Tracy\ILogger $logger
	) {
		$this->contactEmailFactory = $contactEmailFactory;
		$this->mailer = $mailer;
		$this->flashMessagesControlFactory = $flashMessagesControlFactory;
		$this->logger = $logger;
	}


	public function render()
	{
		$this['form']->setAction($this['form']->getAction() . '#mam-zajem');

		$this->getTemplate()->setFile(__DIR__ . '/ContactControl.latte');
		$this->getTemplate()->render();
	}


	protected function createComponentForm()
	{
		$form = new Nette\Application\UI\Form();

		$nameControl = $form->addText('name');
		$nameControl->setRequired();

		$emailControl = $form->addText('email');
		$emailControl->setType('email');
		$emailControl->setRequired();

		$form->addText('phone');

		$form->addText('linkedIn');

		$form->addTextArea('additional');

		$cvControl = $form->addUpload('cv');
		$cvControl->addRule(Nette\Forms\Form::MAX_FILE_SIZE, 'Maximální velikost souboru je 5 MB.', 5 * 1024 * 1024);
		$cvControl
			->addCondition(Nette\Forms\Form::FILLED)
			->addRule(Nette\Forms\Form::MIME_TYPE, 'Povoleny jsou soubory PDF.', 'application/pdf')
		;

		$form->addProtection('Formulář nebyl odeslaný příliš dlouho, odešlete ho prosím znovu');

		$form->addSubmit('submit');

		$form->onSuccess[] = function (Nette\Application\UI\Form $form, array $values) {
			$this->processForm($form, $values);
		};

		$form->onError[] = function (Nette\Application\UI\Form $form) {
			foreach ($form->getErrors() as $error) {
				$this->flashMessage($error, DelejCoUmis\Controls\FlashMessages\FlashMessagesControl::ERROR);
			}
		};

		return $form;
	}


	private function processForm(Nette\Application\UI\Form $form, array $values)
	{

		$message = $this->contactEmailFactory->create(
			$values['name'],
			$values['email'],
			$values['phone'],
			$values['linkedIn'],
			$values['additional'],
			$values['cv']
		);
		try {
			$this->mailer->send($message);
			$this->flashMessage(
				'Odesláno, brzy tě budeme kontaktovat :)',
				DelejCoUmis\Controls\FlashMessages\FlashMessagesControl::OK
			);
			$this->redirect('this');
		} catch (Nette\Mail\SendException $e) {
			$this->logger->log($e, Tracy\ILogger::EXCEPTION);
			$this->flashMessage(
				'Jujky, něco se polámalo a neodeslalo :(',
				DelejCoUmis\Controls\FlashMessages\FlashMessagesControl::ERROR
			);
		}
	}


	protected function createComponentFlashMessages()
	{
		return $this->flashMessagesControlFactory->create();
	}
}
