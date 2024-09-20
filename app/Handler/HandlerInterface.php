<?php

namespace App\Handler;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface HandlerInterface {
    public function store(array $payload): Model;
    public function list(array $query): LengthAwarePaginator;
}
