<?php

namespace App\Traits;

trait UpdateTrait
{
    public function updateTrait($model, $id, $data)
    {
        $model::find($id)->update($data);
        return back();
    }
}