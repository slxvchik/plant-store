<?php

namespace App\Application\UserRequest\SaveFormRequest;

use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use App\Domain\UserRequest\UserRequestModel;
use App\Domain\UserRequest\UserRequestRepository;

readonly class SaveFormRequestService implements SaveFormRequestUseCase
{
    public function __construct(
        private UuidGeneratorInterface $uuidGenerator,
        private UserRequestRepository $userRequestRepository
    ) {}

    public function execute(SaveFormRequestDto $saveFormRequestDto): string
    {
        $userRequest = UserRequestModel::createNew(
            uuidGenerator: $this->uuidGenerator,
            formName: $saveFormRequestDto->formName,
            FIO: $saveFormRequestDto->FIO,
            email: $saveFormRequestDto->email,
            phone: $saveFormRequestDto->phone,
            comment: $saveFormRequestDto->comment
        );

        $this->userRequestRepository->create($userRequest);

        return $userRequest->id->value;
    }
}
