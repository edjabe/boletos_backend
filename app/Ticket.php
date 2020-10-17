<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    //

    protected $fillable = [
        'day', 'event_name', 'quantity', 'start_time', 'finish_time', 'description'
    ];
}
