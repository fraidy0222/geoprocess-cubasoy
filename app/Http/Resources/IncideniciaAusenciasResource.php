<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IncideniciaAusenciasResource extends JsonResource
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
            'id' =>$this->id,
            'ueb' => $this->ueb->name,
            'certificados_medicos' => $this->certificados_medicos,
            'lic_maternidad' => $this->lic_maternidad,
            'vacaciones' => $this->vacaciones,
            'aus_autorizadas' => $this->aus_autorizadas,
            'aus_injustificadas' => $this->aus_injustificadas,
            'otras' => $this->otras,
            'aislados' => $this->aislados,
            'positivos' => $this->positivos,
            'madres_ninnos' => $this->madres_ninnos,
        ];
    }
}
