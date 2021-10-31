<?php

namespace App\Domain\Users\Cache;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class RedisPaginator
{
    /**
     * Query builder that will be used
     * To get data from db and then cache in redis
     */
    private Builder $builder;

    /**
     * Cache key that will be used as redis key
     */
    private string $cacheKey;

    /**
     * We tag result on redis, to wipe all the user cache
     */
    private ?string $cacheTag;

    /**
     * Per page indicates how many record we will fetch per page
     */
    private int $perPage    = 20;

    /**
     * Flag to skip caching for special case
     */
    private bool $skipCache = false;

    /**
     * TTL time of the cache
     */
    private int $cacheTTL = 60;

    public function __construct(Builder $query, string $cacheKey, int $perPage = 20, ?string $cacheTag = null)
    {
        $this->builder  = $query;
        $this->cacheKey = $cacheKey;
        $this->cacheTag = $cacheTag;
        $this->perPage  = $perPage;

        $this->buildTag();
    }

    public function paginate(int $page = 1): LengthAwarePaginator
    {
        // If the cache present on the cache, return the data
        if ($this->existsInCache($page)) {
            return $this->getFromCache($page);
        }

        // Skip caching for special case, i.e. when no filtering not indicated
        if ($this->skipCache === false) {
            /**
             * We can run caching task in the job/queue to reduce user wait time, 
             * I am running this here for simplicity for now.
             */
            $this->cacheAllResult();
        }

        // Return the result from db for the first time
        return (clone $this->builder)->paginate($this->perPage, ['*'], 'page', $page);
    }

    /**
     * Disable caching during run time of the query
     */
    public function skipCaching(): self
    {
        $this->skipCache = true;

        return $this;
    }

    /**
     * Build the tag dynamically if not given
     */
    private function buildTag(): void
    {
        if ($this->cacheTag) {
            return;
        }

        $tableName      = $this->builder->getModel()->getTable();
        $this->cacheTag = $tableName . ':filter';
    }

    /**
     * Check if the data exists in the cache
     */
    protected function existsInCache(int $page): bool
    {
        $pageKey    = "{$this->cacheKey}:$page";
        $perPageKey = "{$this->cacheKey}:perPage";

        $cache = $this->getCacheInstance();

        if ($cache->has($pageKey) && $cache->has($perPageKey)) {
            return true;
        }

        return false;
    }

    /**
     * Get the records from the page
     */
    private function getFromCache(int $page): LengthAwarePaginator
    {
        $pageKey  = "{$this->cacheKey}:$page";
        $totalKey = "{$this->cacheKey}:total";

        $cache = $this->getCacheInstance();

        $data  = $cache->get($pageKey);
        $total = $cache->get($totalKey);

        return $this->prepareData($data, $total, $page);
    }

    /**
     * Prepare retrieved data from cache for response
     */
    private function prepareData(string $data, int $total, int $current): LengthAwarePaginator
    {
        $data = json_decode($data);

        return new LengthAwarePaginator($data, $total, $this->perPage, $current);
    }

    /**
     * Fetch all data from database and then cache into redis as paginated data
     */
    private function cacheAllResult(): void
    {
        // Invalidate previous cache
        $this->getCacheInstance()->flush();

        $index = 1;
        $this->builder->chunkById(200, function ($users) use (&$index) {
            // Chunk the result according to per page value
            $chunked = $users->chunk($this->perPage);

            // Store the result by adding the page number at the end of cache key
            foreach ($chunked as $result) {
                $index_key = $this->cacheKey . ':' . $index;

                $this->getCacheInstance()->put($index_key, json_encode($result), $this->cacheTTL);

                $index++;
            }
        });

        // Save meta info about the pagination
        $total = $this->builder->count();
        $this->getCacheInstance()->put($this->cacheKey . ':total', $total, $this->cacheTTL);
        $this->getCacheInstance()->put($this->cacheKey . ':perPage', $this->perPage, $this->cacheTTL);
    }

    /**
     * Helper method for the cache with tags
     */
    private function getCacheInstance()
    {
        return cache()->tags([$this->cacheTag]);
    }
}
