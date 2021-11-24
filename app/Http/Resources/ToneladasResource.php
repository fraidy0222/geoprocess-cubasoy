<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ToneladasResource extends JsonResource
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
            'venta_d' => $this->venta_d,
            'acum_mes' => $this->acum_mes,
            'acum_fecha' => $this->acum_fecha,
            'acopio' => $this->acopio,
            'eam' => $this->eam,
            'encarg_estatal' => $this->encarg_estatal,
            'cayo_cruz' => $this->cayo_cruz,
            'i_ceballos' => $this->i_ceballos,
            'fruta_select' => $this->fruta_select,
            'industria' => $this->industria,
            'otros' => $this->otros,
            'semilla' => $this->semilla,
            'es_camaguey' => $this->es_camaguey,

        ];
    }
}
