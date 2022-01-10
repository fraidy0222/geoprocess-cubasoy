<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IncidenciaEnergiaResource extends JsonResource
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
            'plan_mes_energia' => $this->plan_mes_energia,
            'plan_real_energia' => $this->plan_real_energia,
            'porciento_energia' => $this->porciento_energia,
            'plan_mes_petroleo' => $this->plan_mes_petroleo,
            'plan_real_petroleo' => $this->plan_real_petroleo,
            'porciento_petroleo' => $this->porciento_petroleo
        ];
    }
}
