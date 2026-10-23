<?php

declare(strict_types=1);

namespace App\Notification;

use App\Domain\Shared\AppException\AppException;

readonly class Notification
{
    public function __construct(
        public string $message,
        public NotificationType $type
    ) {}

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'type' => $this->type->value,
        ];
    }

    public static function fromAppException(AppException $appException): array
    {
        return [
            'message' => $appException->getMessage(),
            'type' => NotificationType::ERROR,
        ];
    }
}
