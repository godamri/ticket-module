<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;


    protected $fillable = [
        'ticket_title',
        'ticket_msg',
        'user_id',
        'ticket_status',
    ];
    public function status()
    {
        switch ($this->ticket_status) {
            case 'cld':
                return 'Closed';
            case 'asn':
                return 'Assigned';
            case 'opn':
            default:
                return 'Open';
        }
    }
}
