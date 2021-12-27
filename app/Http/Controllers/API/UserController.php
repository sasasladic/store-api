<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ContactRequest;
use App\Mail\SupportMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends BaseController
{
    public function sendMail(ContactRequest $request)
    {
        Mail::to('contact@galeja.net')->locale(app()->getLocale())->send(new SupportMessage($request->validated()));

        return $this->returnResponseSuccess([], 'Message successfully sent!');
    }
}
