<?php

interface NotifierInterface
{
    public function setMessage($message);
    public function setRecipient($recipient);
    public function notify();
}