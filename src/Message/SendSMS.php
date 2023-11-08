<?php

namespace App\Message;
class SendSMS
{
    public function __construct(
        private string $userId,
    ){
    }

    public function getUserID(): string
    {
        return $this->userId;
    }

    public function getRandomDigit(): int
    {
        return random_int(1,9);
    }
}