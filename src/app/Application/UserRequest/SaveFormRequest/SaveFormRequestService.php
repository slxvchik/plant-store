<?php

namespace App\Application\UserRequest\SaveFormRequest;

use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use App\Domain\UserRequest\Model\UserRequest;
use App\Domain\UserRequest\Repository\UserRequestRepository;

readonly class SaveFormRequestService implements SaveFormRequestUseCase
{
    public function __construct(
        private UuidGeneratorInterface $uuidGenerator,
        private UserRequestRepository $userRequestRepository
    ) {}
    public function execute(SaveFormRequestDto $saveFormRequestDto): string
    {
        $userRequest = UserRequest::createNew(
            uuidGenerator: $this->uuidGenerator,
            formId: $saveFormRequestDto->formId,
            FIO: $saveFormRequestDto->FIO,
            email: $saveFormRequestDto->email,
            phone: $saveFormRequestDto->phone,
            comment: $saveFormRequestDto->comment
        );

        $this->userRequestRepository->create($userRequest);

        return $userRequest->id->value;
    }
}
