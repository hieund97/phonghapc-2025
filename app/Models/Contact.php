<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Contact extends Model
{
    use HasFactory;

    public const STATUS = [
        1 => 'proccessed',
        2 => 'proccessing',
        3 => 'unproccessed',
    ];

    public const IMPORTANT = [
        1 => 'very_important',
        2 => 'important',
        3 => 'normal',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname',
        'title',
        'issue',
        'email',
        'phone_number',
        'contact_receiver_id',
        'address',
        'content',
        'is_important',
        'id_card_number',
        'status',
        'note',
        'city',
        'district',
        'user_created',
        'user_updated',
    ];

    /**
     * Get the contact receiver that owns the Contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver()
    {
        return $this->belongsTo(ContactReceiver::class, 'contact_receiver_id', 'id');
    }

    /**
     * Get the page's seo meta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, 'model', 'model', 'model_id');
    }
}
