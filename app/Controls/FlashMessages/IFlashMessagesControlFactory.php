<?php

namespace DelejCoUmis\Controls\FlashMessages;

interface IFlashMessagesControlFactory
{

	/**
	 * @return FlashMessagesControl
	 */
	public function create();
}
