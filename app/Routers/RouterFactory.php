<?php

namespace DelejCoUmis\Routers;

use Nette;


class RouterFactory
{

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new Nette\Application\Routers\RouteList();
		$router[] = new Nette\Application\Routers\Route('/', 'Ad:selfEmployedProgrammer');

		return $router;
	}

}
