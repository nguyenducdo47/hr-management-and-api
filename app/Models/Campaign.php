<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
        'description',
        'template_id',
        'is_sent',
        'scheduled_at',
        'start_from'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function emailTemplate()
    {
        return $this->belongsTo(EmailTemplate::class);
    }
}
