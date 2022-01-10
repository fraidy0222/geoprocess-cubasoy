<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiarioResource extends JsonResource
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
            'cultivo' => $this->cultivo->name,
            't_diario' => $this->t_diario,
            't_plan' => $this->t_plan,
            't_real' => $this->t_real,
            'porciento' => $this->porciento,
        ];
    }
}
