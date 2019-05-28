<?php

namespace App\Model\Traits\Eloquent;

use App\Model\Eloquent\User;
use Illuminate\Database\Eloquent\Model;

trait HistoryCreatedBy
{

    public static function bindCreator(Model $source, Model $history)
    {
        $history->created_by = (!is_null($source->updated_by)) ? $source->updated_by : $source->created_by;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

}
