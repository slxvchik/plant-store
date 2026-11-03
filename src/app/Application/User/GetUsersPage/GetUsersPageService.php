<?php

declare(strict_types=1);

namespace App\Application\User\GetUsersPage;

use App\Application\User\Shared\Dto\Response\UserResponseDto;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\User\Repository\UserRepository;
use Override;

readonly class GetUsersPageService implements GetUsersPageUseCase
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    #[Override]
    public function execute(Pageable $pageable): Page
    {
        $page = $this->userRepository->findPage($pageable);

        $userResponseDtos = [];
        foreach ($page->items as $user) {
            $userResponseDtos[] = UserResponseDto::fromDomain($user);
        }

        return $page->changeItems($userResponseDtos);
    }
}
