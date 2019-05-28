<?php

namespace App\Http\Controllers\Traits;

use Storage;
use \App\Model\Eloquent\File as FileEloquent;
use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Collection;

trait FileReferable
{
    protected function copyFileRefer(Model $sourceModel, Model $targetModel, $unit = null)
    {
        $sourceFiles = $sourceModel->files()->get();
        $targetFiles = $this->copyFiles($sourceFiles);
        $this->bindFileReferByFiles($targetModel, $targetFiles, $unit);
    }

    protected function updateFileRefer(Model $model, $syncList = [], $unit = null)
    {
        $oldFiles = $model->files()->get();
        $oldFiles->each(function ($file) use ($syncList) {
            if (!in_array($file->id, $syncList)) {
                $file->delete();
            }
        });
        $this->bindFileReferByIds($model, $syncList, $unit);
    }

    protected function bindFileReferByIds(Model $model, $syncList = [], $unit = null, $force = false)
    {
        if (count($syncList) === 0) {
            return;
        }
        $files = FileEloquent::whereIn('id', $syncList)->get();
        $this->bindFileReferByFiles($model, $files, $unit, $force);
    }

    protected function bindFileReferByFiles(Model $model, Collection $files, $unit = null, $force = false)
    {
        $files->each(function ($file) use (&$model, $unit, $force) {
            if (!$file->hasRefer() || $force) {
                $file->bindRefer(get_class($model), $model->id);
            }
        });
    }

    protected function copyFiles(Collection $files)
    {
        return $files->map(function ($file) {
            return $this->copyFile($file);
        })->filter(function ($value, $key) {
            return !is_null($value);
        });
    }

    protected function copyFile(FileEloquent $file)
    {
        if (Storage::has($file->realpath)) {
            $newFileName = strval(time()) . str_random(5) . '.' . $file->extension;
            $newPath = str_replace(pathinfo($file->realpath, PATHINFO_BASENAME), $newFileName, $file->realpath);
            Storage::copy($file->realpath, $newPath);
            $newFile = new FileEloquent($file->toArray());
            $newFile->bindRefer(null, null);
            $newFile->realpath = $newPath;
            $newFile->save();
            return $newFile;
        }
        return null;
    }
}
