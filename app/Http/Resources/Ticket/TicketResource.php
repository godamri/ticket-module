<?php

namespace App\Http\Resources\Ticket;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ticket_title' => $this->ticket_title,
            'ticket_msg' => $this->ticket_msg,
            'ticket_status' => $this->ticket_status,
            'status' => $this->status(),
            'user_id' => $this->user_id,
            'created_at' => $this->created_at
        ];
    }
}
