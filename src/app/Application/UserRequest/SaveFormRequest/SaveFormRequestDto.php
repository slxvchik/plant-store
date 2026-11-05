<?php

declare(strict_types=1);

namespace App\Application\UserRequest\SaveFormRequest;

readonly class SaveFormRequestDto
{
    public function __construct(
        public string $FIO,
        public string $phone,
        public ?string $formName = null,
        public ?string $email = null,
        public ?string $comment = null
    ) {}
}
