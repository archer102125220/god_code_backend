<?php

namespace App\Model\Traits\Eloquent;

use Illuminate\Database\Eloquent\Model;

trait HasHistory
{

    public function history()
    {
        return $this->hasMany($this->historyModel);
    }

}
