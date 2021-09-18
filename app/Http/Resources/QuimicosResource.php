<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuimicosResource extends JsonResource
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
            'tipo_aplicacion' => $this->tipo_aplicacion,
            'tipo_producto' => $this->tipo_producto,
            'area_aplicada' => $this->area_aplicada,
            'area_acum' => $this->area_acum,
            'cant' => $this->cant,
            'cant_equipos' => $this->cant_equipos,
            'comienza' => $this->comienza,
            'termina' => $this->termina
        ];
    }
}
