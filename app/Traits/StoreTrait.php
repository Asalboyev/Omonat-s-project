<?php

namespace App\Traits;

trait StoreTrait
{
    public function storeTrait($model, $data)
    {
        $model::create($data);
        return back();
    }
}