<?php

namespace App\Model\Traits\Eloquent;

use Illuminate\Database\Eloquent\Model;

trait OnlyCreatedAt
{

    public static function bootOnlyCreatedAt()
    {
        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

}
