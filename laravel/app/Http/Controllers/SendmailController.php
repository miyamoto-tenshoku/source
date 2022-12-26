<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Sendmail;

use Arcanedev\NoCaptcha\Rules\CaptchaRule;

class SendmailController extends Controller
{
    public function index()
    {
        return view('sendmail.view');
    }

    public function post(Request $req)
    {
        $req->validate([
            'email' => 'required|email',
            'g-recaptcha-response' => ['required', new CaptchaRule]
        ],
        [
            'email.required' => 'メールアドレスが未入力です',
            'email.email' => 'メールアドレスの形式に誤りがあります',
            'g-recaptcha-response.required' => 'reCAPTCHAが未チェックです',
            'g-recaptcha-response.captcha'  => '不正なアクセスを検知しました',
        ]);

        Mail::send(new Sendmail($req->get('email')));
        return  redirect()->route('sendmail')->with('successMessage', 'メールを送信しました');
    }
}
