<?php

namespace App\Console\Commands;

use App\Application\User\CreateUser\CreateUserRequestDto;
use App\Application\User\CreateUser\CreateUserUseCase;
use App\Application\User\RegisterUser\RegisterUserRequestDto;
use App\Application\User\RegisterUser\RegisterUserUseCase;
use App\Application\User\UpdateUser\UpdateUserRequestDto;
use App\Application\User\UpdateUser\UpdateUserUseCase;
use App\Domain\Shared\AppException\AppException;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:create-admin {--firstname=} {--lastname=} {--email=} {--phone=} {--password=}')]
#[Description('Admin user creation')]
class CreateAdmin extends Command
{
    protected $signature = 'app:create-admin';

    /**
     * Execute the console command.
     */
    public function handle(CreateUserUseCase $createUserUseCase, UpdateUserUseCase $updateUserUseCase): void
    {
        try {
            $createUserUseCase->execute(new CreateUserRequestDto(
                firstName: $this->option('firstname'),
                lastName: $this->option('lastname'),
                email: $this->option('email'),
                phone: $this->option('phone'),
                password: $this->option('password'),
                emailConfirmed: true,
                imageId: null,
                roles: ['USER', 'ADMIN', 'MANAGER', 'WAREHOUSE_WORKER'],
            ));
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}
