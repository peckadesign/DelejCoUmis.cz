<?php

namespace DelejCoUmis\Controls\Contact;

interface IContactControlFactory
{

	/**
	 * @return ContactControl
	 */
	public function create();
}
