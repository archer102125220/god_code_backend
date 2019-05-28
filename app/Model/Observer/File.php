<?php

namespace App\Model\Observer;

use Illuminate\Support\Facades\Storage;

class File
{

    /**
     * 模型刪除事件
     *
     * @param  App\Model\Eloquent\File $file 被刪除的模型
     * @return
     */
    public function deleting($file)
    {
        Storage::delete($file->realpath);
    }

}
