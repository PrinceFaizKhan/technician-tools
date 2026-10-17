<?php

namespace App\Services;

use App\Models\ErrorCode;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

/**
 * Singleton service for optimized error code searching and filtering.
 */
class ErrorCodeSearchService
{
    /**
     * Search and filter error codes with eager-loaded relations and pagination.
     *
     * @param array{
     *     search?: ?string,
     *     appliance_id?: ?int,
     *     brand_id?: ?int,
     *     filter_id?: ?int,
     *     per_page?: int
     * } $filters
     */
    public function search(array $filters): LengthAwarePaginator
    {
        $query = ErrorCode::query()
            ->with(['appliance', 'brand', 'filter'])
            ->where('is_active', true);

        if (! empty($filters['appliance_id'])) {
            $query->where('appliance_id', $filters['appliance_id']);
        }

        if (! empty($filters['brand_id'])) {
            $query->where('brand_id', $filters['brand_id']);
        }

        if (! empty($filters['filter_id'])) {
            $query->where('filter_id', $filters['filter_id']);
        }

        if (! empty($filters['search'])) {
            $search = trim($filters['search']);
            $query->where(function (Builder $q) use ($search): void {
                $q->where('code', 'LIKE', "%{$search}%")
                    ->orWhere('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhere('cause', 'LIKE', "%{$search}%");
            });
        }

        $perPage = (int) ($filters['per_page'] ?? 20);

        return $query->latest('id')->paginate($perPage);
    }
}
