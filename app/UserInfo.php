<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $fillable = [
        'iban', 'identity_document', 'billing_address'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
