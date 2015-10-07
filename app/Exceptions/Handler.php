<?php namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
               /* if($e instanceof \PDOException){
                    die($e->getCode(). " :" .$e->getMessage());
                }*/
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
            if ($this->isHttpException($e))
            {
                return $this->renderHttpException($e);
            }


            if (config('app.debug'))
            {
                return $this->renderExceptionWithWhoops($e);
            }

            return parent::render($request, $e);

	}

        /**
         * Render an exception using Whoops.
         *
         * @param  \Exception $e
         * @return \Illuminate\Http\Response
         */
        protected function renderExceptionWithWhoops(Exception $e)
        {
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());

            return new \Illuminate\Http\Response(
                $whoops->handleException($e),
                $e->getStatusCode(),
                $e->getHeaders()
            );
        }

}
