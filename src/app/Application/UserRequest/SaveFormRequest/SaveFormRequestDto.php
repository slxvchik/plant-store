<?php

declare(strict_types=1);

namespace App\Application\UserRequest\SaveFormRequest;

readonly class SaveFormRequestDto
{
    public function __construct(
        public ?string $formId = null,
        public ?string $FIO = null,
        public ?string $email = null,
        public ?string $phone = null,
        public ?string $comment = null
    ) {}
}
