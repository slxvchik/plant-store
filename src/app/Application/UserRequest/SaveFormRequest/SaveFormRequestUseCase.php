<?php

namespace App\Application\UserRequest\SaveFormRequest;

interface SaveFormRequestUseCase
{
    public function execute(SaveFormRequestDto $saveFormRequestDto): string;
}
