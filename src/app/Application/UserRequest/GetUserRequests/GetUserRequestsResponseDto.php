<?php

declare(strict_types=1);

namespace App\Application\UserRequest\GetUserRequests;

use App\Domain\UserRequest\Model\UserRequest;
use JsonSerializable;
use Override;

readonly class GetUserRequestsResponseDto implements JsonSerializable
{
    public function __construct(
        public string $id,
        public ?string $FIO,
        public ?string $email,
        public ?string $phone,
        public ?string $comment,
    ) {}

    public static function fromDomain(UserRequest $userRequest): self
    {
        return new self(
            id: $userRequest->id->value,
            FIO: $userRequest->FIO,
            email: $userRequest->email,
            phone: $userRequest->phone,
            comment: $userRequest->comment,
        );
    }

    /**
     * @return array{id: string, fio: ?string, email: ?string, phone: ?string, comment: ?string}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'fio' => $this->FIO,
            'email' => $this->email,
            'phone' => $this->phone,
            'comment' => $this->comment,
        ];
    }
}
