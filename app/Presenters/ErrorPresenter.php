<?php

namespace DelejCoUmis\Presenters;

use Nette;
use Tracy;


class ErrorPresenter extends Nette\Object implements Nette\Application\IPresenter
{
	/**
	 * @var Tracy\ILogger
	 */
	private $logger;


	public function __construct(Tracy\ILogger $logger)
	{
		$this->logger = $logger;
	}


	public function run(Nette\Application\Request $request)
	{
		$exception = $request->getParameter('exception');

		if ($exception instanceof Nette\Application\BadRequestException) {
			return new Nette\Application\Responses\ForwardResponse($request->setPresenterName('Error4xx'));
		}

		$this->logger->log($exception, Tracy\ILogger::EXCEPTION);
		return new Nette\Application\Responses\CallbackResponse(function () {
			require __DIR__ . '/templates/Error/500.phtml';
		});
	}

}
