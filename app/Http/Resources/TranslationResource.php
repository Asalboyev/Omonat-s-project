<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TranslationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'key' => $this->key,
            'value' => $this->val['ru'] ?? $this->val['ar'] ?? $this->val['en'] ?? null,
        ];
    }
}
