<?php

namespace App\Model\Traits\Eloquent;

use Illuminate\Database\Eloquent\Model;

trait OnlyUpdatedAt
{

    public static function bootOnlyUpdatedAt()
    {
        static::creating(function ($model) {
            $model->updated_at = $model->freshTimestamp();
        });
    }

}
