<?php

namespace DelejCoUmis\Controls\FlashMessages;

use Nette;


class FlashMessagesControl extends Nette\Application\UI\Control
{

	const OK = 'ok';
	const ERROR = 'error';
	const INFO = 'info';


	public function render()
	{
		$flashes = $this->parent->getTemplate()->flashes;
		$this->getTemplate()->flashes = $flashes;
		$this->getTemplate()->render(__DIR__ . '/FlashMessagesControl.latte');
	}

}


