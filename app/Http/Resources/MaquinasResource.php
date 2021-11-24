<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaquinasResource extends JsonResource
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
            'total_maquinas_riego' => $this->total_maquinas_riego,
            'maquinas_listas' => $this->maquinas_listas,
            'maquinas_rotas' => $this->maquinas_rotas,
            'afectaciones' => $this->afectaciones,
            'comienza' => $this->comienza,
            'termina' => $this->termina,
        ];
    }
}
