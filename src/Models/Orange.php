<?php

namespace MiladZamir\Orange\Models;

use Illuminate\Database\Eloquent\Model;

class Orange extends Model
{
    protected $fillable = ['status', 'result_message', 'message_id', 'message', 'status_entries', 'status_text', 'sender', 'receptor' , 'date', 'cost' ];
    protected $dates = ['date'];
}
