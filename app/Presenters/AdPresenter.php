<?php

namespace DelejCoUmis\Presenters;

use DelejCoUmis;
use Nette;


class AdPresenter extends Nette\Application\UI\Presenter
{

	/**
	 * @var DelejCoUmis\Controls\Contact\IContactControlFactory
	 * @inject
	 */
	public $contactControlFactory;


	protected function createComponentContact()
	{
		return $this->contactControlFactory->create();
	}
}
