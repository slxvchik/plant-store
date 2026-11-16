<?php

namespace App\Domain\Shared\Contracts;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
class Transactional {}
