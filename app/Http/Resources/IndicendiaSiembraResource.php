<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IndicendiaSiembraResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
             'ueb' => $this->ueb->name,
            'cultivo' => $this->cultivo->name,
            'cc' => $this->cc,
            'area' => $this->area,
            'siembrap' => $this->siembrap,
            'siembraa' => $this->siembraa, 
            'siembrad' => $this->siembrad,
            'cantsemillad' => $this->cantsemillad,
            'cantsemillaa' => $this->cantsemillaa,
            'cantsemillaud' => $this->cantsemillaud,
            'cantsemillaua' => $this->cantsemillaua,
        ];;
    }
}
