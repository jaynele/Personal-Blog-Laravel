<?php

namespace App\Http\Middleware;

use Closure;
use Nette\Mail\Message;
use Nette\Mail\SmtpMailer;
class AdminMail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $mail = new Message;
        $mail->setFrom('jL <15022080597@163.com>')
            ->addTo('1798805740@qq.com')
            ->setSubject('0619999订单确定!')
            ->setBody('hello,你的订单已接收!');


        $mailer = new SmtpMailer([
                'host'=>'smtp.163.com',
                'username'=>'15022080597@163.com',
                'password'=>'775811qewa'
            ]
        );
        $mailer->send($mail);

        return $next($request);

    }
}
