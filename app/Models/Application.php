<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AppBaseModel;

class Application extends AppBaseModel
{
    use HasFactory;

    protected $fillable = [
        'application_code', 'client_id', 'career_id', 'status_id', 'remarks'
    ];

    // Relationships
    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function career(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Career::class);
    }

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function payments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ApplicationPayment::class);
    }
}
