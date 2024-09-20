<?php

namespace App\Http\Controllers\Rest;

use App\Exceptions\GlobalException;
use App\Handler\TicketHandler;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Ticket\TicketCollection;

class TicketController extends Controller
{
    protected $handler;
    public function __construct()
    {
        $this->handler = new TicketHandler;
    }
    public function store()
    {
        $sanitized = request()->validate([
            'ticket_title' => 'required|string|min:10|max:100',
            'ticket_msg' => 'required|string|min:100',
            'user_id' => 'required|numeric',
        ]);

        $ticket = $this->handler->store($sanitized);
        return response()->json([
            'id' => $ticket->id
        ], 201);
    }

    /**
     * List ticket with pagination
     * 
     * Supported filter:
     * - `before` and `after` will be used for created_at filter
     * - `between` will be used for created_at filter with range value
     * 
     * Supported sort:
     * - `created_at` and `user_id`
     * 
     * @param array $query
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function list()
    {
        $rules = [
            'sort' => 'array',
            'sort.name' => 'in:created_at,user_id',
            'sort.dir' => 'in:asc,desc',
            'page_size' => 'numeric',
            'filter' => 'array',
            'filter.filter_name' => 'in:created_at,updated_at',
            'filter.filter_type' => 'in:before,after,between',
            'filter.filter_value' => 'string',
        ];
        if (request()->has('filter.filter_name')) {
            $rules['filter.filter_name'] = 'required|in:created_at,updated_at';
            $rules['filter.filter_type'] = 'required|in:before,after,between';
            $rules['filter.filter_value'] = 'required|string';
        }
        if (request()->has('sort.name')) {
            $rules['sort.name'] = 'required|in:created_at,user_id';
            $rules['sort.dir'] = 'required|in:asc,desc';
        }
        $query = request()->validate($rules);
        return new TicketCollection($this->handler->list($query));
    }
}
