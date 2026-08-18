<?php

namespace App\Domain\User\Event;

readonly class SendConfirmEmailEvent
{
    public function __construct(
        public string $userId,
        public string $email,
        public string $confirmToken
    ) {}
}
