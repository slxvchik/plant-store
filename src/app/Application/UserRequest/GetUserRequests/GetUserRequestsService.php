<?php

declare(strict_types=1);

namespace App\Application\UserRequest\GetUserRequests;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\UserRequest\Repository\UserRequestRepository;
use Override;

readonly class GetUserRequestsService implements GetUserRequestsUseCase
{
    public function __construct(
        private UserRequestRepository $userRequestRepository
    ) {}

    #[Override]
    public function execute(Pageable $pageable): Page
    {
        $page = $this->userRequestRepository->findPage($pageable);
        $userResponseDtos = [];
        foreach ($page->items as $userRequest) {
            $userResponseDtos[] = GetUserRequestsResponseDto::fromDomain($userRequest);
        }
        return $page->changeItems($userResponseDtos);
    }
}
