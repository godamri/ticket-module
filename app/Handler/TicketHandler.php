<?php

namespace App\Handler;

use App\Models\Ticket;
use Illuminate\Support\Str;
use App\Exceptions\GlobalException;
use App\Helpers\Facades\Helper;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

class TicketHandler implements HandlerInterface
{

    /**
     * Store a newly created ticket in storage.
     *
     * @param  array  $payload
     * @return \App\Models\Ticket
     * @throws \App\Exceptions\GlobalException
     */
    public function store(array $payload): Ticket
    {
        if (Ticket::where([
            'ticket_title' => $payload['ticket_title'],
            'user_id' => $payload['user_id'],
        ])->where('created_at', '>=', Carbon::now()->subMinutes(5))->first()) {
            throw new GlobalException('Duplicate Data', 409);
        }
        try {
            $store = Ticket::create($payload);
        } catch (\Exception $e) {
            $head = Str::uuid();
            Log::error(sprintf('%s - %s %s', $head, $e->getMessage(), $e->getTraceAsString()));
            throw new GlobalException(sprintf('#%s - Your request cannot be proceed, please try again', $head));
        }
        return $store;
    }

    /**
     * List ticket with pagination.
     *
     * Supported filter:
     * - `before` and `after` will be used for created_at filter
     * - `between` will be used for created_at filter with range value
     *
     * Supported sort:
     * - `created_at` and `user_id`
     *
     * @param array $query
     * @return LengthAwarePaginator
     */
    public function list(array $query): LengthAwarePaginator
    {
        $tickets = Ticket::select('*');
        if (isset($query['filter'])) {
            if ($query['filter']['filter_type'] == 'between') {

                $tickets->where(function ($q) use ($query) {
                    $between = explode(',', $query['filter']['filter_value']);
                    $q->where($query['filter']['filter_name'], '>=', $between[0])->where($query['filter']['filter_name'], '<=', $between[1]);
                });
            }
            if ($query['filter']['filter_type'] == 'before') {
                $tickets->where($query['filter']['filter_name'], '<', $query['filter']['filter_value']);
            } else {
                $tickets->where($query['filter']['filter_name'], '>', $query['filter']['filter_value']);
            }
        }
        if (isset($query['sort'])) {
            $tickets->orderBy($query['sort']['name'], $query['sort']['dir']);
        }
        $pageSize = 10;
        if (isset($query['page_size'])) {
            $pageSize = Helper::roundToNearestTen($query['page_size']);
            if ($pageSize > 50) {
                $pageSize = 50;
            }
            if ($pageSize < 10) {
                $pageSize = 10;
            }
        }
        return $tickets->paginate($pageSize);
    }
}
