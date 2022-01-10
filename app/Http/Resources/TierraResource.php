<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TierraResource extends JsonResource
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
            'cc' => $this->cc,
            'tipo_peloton' => $this->tipo_peloton,
            'r_plan' => $this->r_plan,
            'r_acum' => $this->r_acum,
            'r_diario' => $this->r_diario,
            'g_plan' => $this->g_plan,
            'g_acum' => $this->g_acum,
            'g_diario' => $this->g_diario,
            'c_plan' => $this->c_plan,
            'c_acum' => $this->c_acum,
            'c_diario' => $this->c_diario,
            's_plan' => $this->s_plan,
            's_acum' => $this->s_acum,
            's_diario' => $this->s_diario,
            'nivelacio_rail' => $this->nivelacio_rail,
        ];
    }
}
