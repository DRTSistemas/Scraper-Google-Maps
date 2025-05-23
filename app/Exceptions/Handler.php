<?php



namespace App\Exceptions;



use Exception;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

use Illuminate\Session\TokenMismatchException;



class Handler extends ExceptionHandler

{

    /**

     * A list of the exception types that are not reported.

     *

     * @var array

     */

    protected $dontReport = [

        //

    ];



    /**

     * A list of the inputs that are never flashed for validation exceptions.

     *

     * @var array

     */

    protected $dontFlash = [

        'password',

        'password_confirmation',

    ];



    /**

     * Report or log an exception.

     *

     * @param  \Exception  $exception

     * @return void

     */

    public function report(Exception $exception)

    {

        parent::report($exception);

    }



    /**

     * Render an exception into an HTTP response.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \Exception  $exception

     * @return \Illuminate\Http\Response

     */

    public function render($request, Exception $exception)
    {

        if (!$request->expectsJson()) {
            if ($exception instanceof TokenMismatchException) {
                return redirect()->route('login')->withErrors([
                    'session' => 'Sua sessão expirou. Por favor, faça login novamente.'
                ]);
            }
    
            if ($exception instanceof MethodNotAllowedHttpException) {
                return redirect('home');
            }
        }
    
        return parent::render($request, $exception);
    }

}

