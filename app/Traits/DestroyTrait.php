<?php

namespace App\Traits;

trait DestroyTrait
{
    public function destroyTrait($model, $id)
    {
        $model::find($id)->delete();
        return back();
    }
}