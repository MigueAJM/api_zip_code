<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Settlement extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settlement';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * one-many.
     */
    public function state()
    {
        return $this->hasMany(State::class);
    }

    /**
     * one-many.
     */
    public function zone()
    {
        return $this->hasMany(ZoneType::class);
    }

    /**
     * one-many.
     */
    public function settlementType()
    {
        return $this->hasMany(SettlementType::class);
    }

    /**
     * one-many.
     */
    public function city()
    {
        return $this->hasMany(City::class);
    }

    /**
     * Get settlements.
     * @param Int $zip_code
     * @return Array
     */
    public function getSettlements($zip_code)
    {
        $data = [];
        $settlements = DB::table('settlement')
            ->join('zone_type', 'settlement.zone_id', '=', 'zone_type.id')
            ->join('settlement_type', 'settlement.settlement_type_id', '=', 'settlement_type.id')
            ->join('city', 'settlement.city_id', '=', 'city.id')
            ->join('state', 'city.state_id', '=', 'state.id')
            ->join('municipality', 'municipality.state_id', '=', 'city.state_id')
            ->select(
                'state.id as id_state',
                'state.name as federal_entity',
                'settlement.zipcode',
                'settlement.code as settlement_key',
                'settlement.name as settlement',
                'zone_type.name as zone_type',
                'settlement_type.name as settlement_type',
                'city.code as city_key',
                'city.name as locality',
                'municipality.code as municipality_key',
                'municipality.name as municipality'
                )
            ->where('zipcode', $zip_code)
            ->whereColumn('municipality.code', 'city.code_municipality')
                
            ->orderBy('settlement.code')
            ->get()
            ->toArray();
            foreach($settlements as $key => $value){
                $data[] = (array)$value;
            }
            $response = [
                'status' => count($data) ? true : false,
                'data' => $data
            ];
         return $response;
    }
}
