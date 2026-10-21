<?php

namespace App\Domain\UserRequest\Model;

use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;

class UserRequest
{
    public private(set) Uuid $id;

    public private(set) ?string $formId;

    public private(set) ?string $FIO;

    public private(set) ?string $email;

    public private(set) ?string $phone;

    public private(set) ?string $comment;

    private function __construct(Uuid $id, ?string $formId, ?string $FIO, ?string $email, ?string $phone, ?string $comment)
    {
        $this->id = $id;
        $this->formId = $formId;
        $this->FIO = $FIO;
        $this->email = $email;
        $this->phone = $phone;
        $this->comment = $comment;
    }

    public static function fromDb(string $id, ?string $formId, ?string $FIO, ?string $email, ?string $phone, ?string $comment): self
    {
        $uuid = new Uuid($id);

        return new self($uuid, $formId, $FIO, $email, $phone, $comment);
    }

    public static function createNew(UuidGeneratorInterface $uuidGenerator, ?string $formId, ?string $FIO, ?string $email, ?string $phone, ?string $comment): self
    {
        $uuid = $uuidGenerator->generate();
        $id = new Uuid($uuid);

        return new self($id, $formId, $FIO, $email, $phone, $comment);
    }
}
