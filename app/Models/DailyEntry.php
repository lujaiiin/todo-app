<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyEntry extends Model
{
    protected $table = 'daily_entries'; // Ensure this matches your table name
    protected $primaryKey = 'day_id';
    use HasFactory;
}
