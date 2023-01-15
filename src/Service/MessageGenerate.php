<?php

namespace App\Service;

use Symfony\Component\Mailer\Mailer;
use Symfony\Contracts\Translation\TranslatorInterface;

class MessageGenerate
{
    private $translator;
    public function __construct(TranslatorInterface $translator)
    {
       $this->translator = $translator;
    }
    public function getHappyMessage(): string
    {
        $messages = [
            'Hope you get to feeling better soon!',
            'Looking forward to seeing you back at practice when you\'re ready.',
            'Wishing you well',
        ];

        $index = array_rand($messages);
        
        return $this->translator->trans($messages[$index]);
    }
    public function getHappyMessage2(): string
    {
        $messages = [
            'Thanks for your good care and concern',
            ' We are  blessed to have you among our doctors',
            'Thank you for being the dedicated, thoughtful, and compassionate doctor that you are!',
        ];

        $index = array_rand($messages);
        
        return $this->translator->trans($messages[$index]);
    }
}