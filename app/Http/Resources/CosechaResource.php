<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CosechaResource extends JsonResource
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
            'area_total' => $this->area_total,
            'a_c_diario' => $this->a_c_diario,
            'a_c_acum' => $this->a_c_acum,
            'a_c_pendiente' => $this->a_c_pendiente,
            't_diario' => $this->t_diario,
            't_acum' => $this->t_acum,
            't_rend' => $this->t_rend,
            'rend_acum' => $this->rend_acum,
            'arranque_m' => $this->arranque_m,
            'cant_equipos' => $this->cant_equipos,
        ];
    }
}
