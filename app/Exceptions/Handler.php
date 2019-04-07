<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
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
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)//例外をログに記載するメソッド
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)//例外発生時の処理をするメソッド、基本常に動いていてifでキャッチしないといけない。
    {
        //ここでエラー発生時の処理をしてる。
        //$requestにはtimeout後に_tokenが格納されてて、$exceptionには各種エラーが格納されている。
        //$requestも$exceptionもAdminやUserを識別できる機能は見つけられなかった。
        //そのため、timeout後のルートはAdminのまま。分けるにはマルチ認証をやめるしかなさそう。api_tokenもここでは消せなかった。

        if ($exception instanceof TokenMismatchException){// csrfエラー（timeout時）だった場合の処理
            session()->flash('csrfError', true);
            return redirect()->to(route('admin.login'));//timeout後は全ルートがadminになってしまう。
        }
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        if (in_array('admin', $exception->guards(), true)) {
            return redirect()->guest(route('admin.login'));
        }

        return redirect()->guest(route('login'));
    }
}