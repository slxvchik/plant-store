<?php

declare(strict_types=1);

namespace App\Application\ProductUnit\Shared\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class ProductUnitAlreadyExistsException extends AppException
{
    public function __construct(string $qrCode)
    {
        parent::__construct(AppExceptionStatus::ALREADY_EXISTS, "Единица товара с QR-кодом «{$qrCode}» уже существует.");
    }
}
