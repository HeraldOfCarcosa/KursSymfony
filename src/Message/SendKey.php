<?php

namespace App\Message;
class SendKey
{
public function __construct(
    private string $userId,
){
}

    public function getUserID(): string
    {
        return $this->userId;
    }

}