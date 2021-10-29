<?php

namespace App\Domain\Users\QueryBuilders;

use App\Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Builder;
use App\Domain\Users\DataTransferObjects\UserFilterData;

class UserFilter
{
    public static function whereBirthday(UserFilterData $filters): Builder
    {
        return User::when($filters->year, function ($query, $year) {
            $query->whereRaw('extract(year from birthday) = ?', $year);
        })->when($filters->month, function ($query, $month) {
            $query->whereRaw('extract(month from birthday) = ?', $month);
        });
    }
}
