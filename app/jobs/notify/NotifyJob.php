<?php

abstract class NotifyJob
{
    protected $notifier;

    protected $message;

    protected $recipient;

    public function executeNotifying()
    {
        $notifierName = $this->notifier.'Notifier';
        $notifier = new $notifierName;
        $notifier->setMessage($this->message);
        $notifier->setRecipient($this->recipient);
        $notifier->notify();
    }
}