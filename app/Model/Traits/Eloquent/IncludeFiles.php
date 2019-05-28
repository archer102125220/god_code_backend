<?php

namespace App\Model\Traits\Eloquent;

use App\Model\ELoquent\File;
use Illuminate\Database\Eloquent\Model;

trait IncludeFiles
{
    public function files()
    {
        return $this->morphMany(File::class, 'referable');
    }
}
