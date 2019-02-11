<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NumeralResource extends JsonResource
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
        	'roman_numeral'				=> $this->roman_numeral,
        	'number_requested'			=> $this->number_requested,
        	'total_number_requested'	=> $this->total_number_requested,
        	'created_at'				=> Carbon::parse($this->created_at)->format('Y-m-d')
		];
    }
}
