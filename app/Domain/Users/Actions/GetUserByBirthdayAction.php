<?php

namespace App\Domain\Users\Actions;

use App\Domain\Users\QueryBuilders\UserFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Domain\Users\DataTransferObjects\UserFilterData;

class GetUserByBirthdayAction
{
    const TAG      = 'user_filter';
    const PER_PAGE = 20;

    public function execute(UserFilterData $filterData, int $page = 1)
    {
        // construct redis key value pair
        $main = ($filterData->year ?? '*') . ':' . ($filterData->month ?? '*');
        $key  = $main . ':' . $page;

        // See if it exists on redis
        if (cache()->tags([self::TAG])->has($key)) {
            $data  = cache()->tags([self::TAG])->get($key);
            $total = cache()->tags([self::TAG])->get($main . ':total');

            return $this->prepareData($data, $total, $page);
        }

        // if not then query database
        $query = UserFilter::whereBirthday($filterData);
        // dd($query->limit(20)->get()->toArray());
        // cache on redis
        cache()->tags([self::TAG])->flush();

        $index = 1;
        $query->chunkById(200, function ($users) use (&$index, $main) {
            $chunked = $users->chunk(20);

            foreach ($chunked as $result) {
                $index_key = $main . ':' . $index;

                cache()->tags([self::TAG])->put($index_key, json_encode($result), 60);

                $index++;
            }
        });

        $total   = $query->count();
        $current = $page;

        cache()->tags([self::TAG])->put($main . ':total', $total);
        $data = cache()->tags([self::TAG])->get($key);

        return $this->prepareData($data, $total, $current);
    }

    private function prepareData(string $data, int $total, int $current)
    {
        $data = json_decode($data);

        return new LengthAwarePaginator($data, $total, self::PER_PAGE, $current);
    }
}
