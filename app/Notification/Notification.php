<?php

declare(strict_types=1);

namespace App\Notification;

use App\Domain\Shared\AppException\AppException;
use JsonSerializable;
use Override;

readonly class Notification implements JsonSerializable
{
    public function __construct(
        public string $message,
        public NotificationType $type
    ) {}

    public static function success(string $message): self
    {
        return new self($message, NotificationType::SUCCESS);
    }

    public static function error(string $message): self
    {
        return new self($message, NotificationType::ERROR);
    }

    /**
     * @return array{message: string, type: string}
     */
    public static function flash(string $message): array
    {
        return self::success($message)->toArray();
    }

    /**
     * @return array{message: string, type: string}
     */
    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'type' => $this->type->value,
        ];
    }

    /**
     * @return array{message: string, type: string}
     */
    public static function fromAppException(AppException $appException): array
    {
        return self::error($appException->getMessage())->toArray();
    }

    /**
     * @return array{message: string, type: string}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
