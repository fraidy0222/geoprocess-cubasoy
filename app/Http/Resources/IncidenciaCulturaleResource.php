<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IncidenciaCulturaleResource extends JsonResource
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
            'tipo_peloton' => $this->tipo_peloton,
            'c_plan' => $this->c_plan,
            'c_acum' => $this->c_acum,
            'c_diario' => $this->c_diario,
            'p_plan' => $this->p_plan,
            'p_acum' => $this->p_acum,
            'p_diario' => $this->p_diario,
            'l_plan' => $this->l_plan,
            'l_acum' => $this->l_acum,
            'l_diario' => $this->l_diario,
            'ch_plan' => $this->ch_plan,
            'ch_acum' => $this->ch_acum,
            'ch_diario' => $this->ch_diario,
            'd_d' => $this->d_d, 
        ];
    }
}
