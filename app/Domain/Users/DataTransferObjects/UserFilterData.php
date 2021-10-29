<?php

namespace App\Domain\Users\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class UserFilterData extends DataTransferObject
{
    public ?string $month;

    public ?string $year;
}
