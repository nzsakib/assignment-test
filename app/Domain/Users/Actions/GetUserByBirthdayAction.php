<?php

namespace App\Domain\Users\Actions;

use App\Domain\Users\Cache\RedisPaginator;
use App\Domain\Users\QueryBuilders\UserFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Domain\Users\DataTransferObjects\UserFilterData;

class GetUserByBirthdayAction
{
    /**
     * Prepare the cache key and then return the result from cache if available
     * If not, then run the DB query, then store it into the cache
     * Finally return the result
     */
    public function execute(UserFilterData $filterData, int $page = 1): LengthAwarePaginator
    {
        // Construct the cache key that will be used to cache the result
        $cacheKey = ($filterData->year ?? '*') . ':' . ($filterData->month ?? '*');

        // Get DB query
        $query = UserFilter::whereBirthday($filterData);

        // Prepare/init the paginator class
        $paginator = new RedisPaginator($query, $cacheKey);

        /**
         * I intentionally skipped caching for all results
         * It can take a while to cache 100k record on user session.
         * We can run the caching on background job to make it seemless for end user later.
         */
        if ($cacheKey === '*:*') {
            $paginator->skipCaching();
        }

        return $paginator->paginate($page);
    }
}
