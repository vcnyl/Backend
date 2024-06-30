<?php

namespace App\Services;

use Twilio\Rest\Client;

class WhatsAppService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    }

    public function sendMessage($to, $message)
    {
        $from = 'whatsapp:' . env('TWILIO_WHATSAPP_FROM');
        $to = 'whatsapp:' . $to;

        $this->twilio->messages->create($to, [
            'from' => $from,
            'body' => $message
        ]);
    }
}