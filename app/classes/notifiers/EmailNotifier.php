<?php

class EmailNotifier implements NotifierInterface
{

    private $message;

    private $recipient;

    public function setMessage($message)
    {
        $this->message = $message;
    }
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }
    public function notify()
    {
        $data = $this->message;
        //dd(compact('data'));
        Mail::send('emails.grades', compact('data'), function ($message) {
            $message->to($this->recipient)->subject('Oceny z DziennikLogin - ' . date('Y - m - d H:i'));
        });
    }
}
