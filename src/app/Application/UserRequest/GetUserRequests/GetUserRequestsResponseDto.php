<?php

declare(strict_types=1);

namespace App\Application\UserRequest\GetUserRequests;

use App\Domain\UserRequest\Model\UserRequest;

readonly class GetUserRequestsResponseDto
{
    public function __construct(
        public string $id,
        public ?string $FIO,
        public ?string $email,
        public ?string $phone,
        public ?string $comment
    ) {}

    public static function fromDomain(UserRequest $userRequest): GetUserRequestsResponseDto
    {
        return new self(
            id: $userRequest->id->value,
            FIO: $userRequest->FIO,
            email: $userRequest->email,
            phone: $userRequest->phone,
            comment: $userRequest->comment
        );
    }
}
