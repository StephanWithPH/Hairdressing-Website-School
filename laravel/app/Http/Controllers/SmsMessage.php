<?php

namespace App\Http\Controllers;

use http\Exception;
use Illuminate\Http\Request;
use MessageBird;

class SmsMessage extends Controller
{
    //
    /**
     * @var mixed
     */
    public $originator;
    /**
     * @var array
     */
    public $recipients;
    /**
     * @var array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public $body;

    public function send(){
        $messagebird = new MessageBird\Client(env('MESSAGEBIRD_KEY'));
        $message = new MessageBird\Objects\Message;
        $message->originator = $this->originator;
        $message->recipients = $this->recipients;
        $message->body = $this->body;
        $response = $messagebird->messages->create($message);
        return $response;
    }
}
