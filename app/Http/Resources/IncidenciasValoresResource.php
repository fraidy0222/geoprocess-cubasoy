<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IncidenciasValoresResource extends JsonResource
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
            'venta_diaria_cup' => $this->venta_diaria_cup,
            'venta_mes_cup' => $this->venta_mes_cup,
            'acumulado' => $this->acumulado,
        ];
    }
}
