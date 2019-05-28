<?php

namespace App\Model\Traits\Eloquent;

use Illuminate\Database\Eloquent\Model;

use Auth;

use App\Model\Eloquent\User;

trait HasCreatedBy{

    public static function bootHasCreatedBy(){
        static::creating(function(Model $model){
            $model->created_by = Auth::id();
        });
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

}
