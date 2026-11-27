<?php

namespace App\Domain\UserRequest;

use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;

class UserRequestModel
{
    public private(set) Uuid $id;

    public private(set) ?string $formName;

    public private(set) string $FIO;

    public private(set) ?string $email;

    public private(set) string $phone;

    public private(set) ?string $comment;

    private function __construct(Uuid $id, ?string $formName, string $FIO, ?string $email, string $phone, ?string $comment)
    {
        $this->id = $id;
        $this->formName = $formName;
        $this->FIO = $FIO;
        $this->email = $email;
        $this->phone = $phone;
        $this->comment = $comment;
    }

    public static function fromDb(string $id, ?string $formName, string $FIO, ?string $email, string $phone, ?string $comment): self
    {
        $uuid = new Uuid($id);

        return new self($uuid, $formName, $FIO, $email, $phone, $comment);
    }

    public static function createNew(UuidGeneratorInterface $uuidGenerator, ?string $formName, string $FIO, ?string $email, string $phone, ?string $comment): self
    {
        $uuid = $uuidGenerator->generate();
        $id = new Uuid($uuid);

        return new self($id, $formName, $FIO, $email, $phone, $comment);
    }
}
