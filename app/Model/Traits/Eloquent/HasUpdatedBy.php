<?php

namespace App\Model\Traits\Eloquent;

use Illuminate\Database\Eloquent\Model;

use Auth;

use App\Model\Eloquent\User;

trait HasUpdatedBy{

    public static function bootHasUpdatedBy(){
        static::updating(function(Model $model){
            $model->updated_by = Auth::id();
        });
    }

    public function editor(){
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

}
