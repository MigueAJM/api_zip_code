<?php

namespace App\Models;

class ZipCodeModel extends DBModel
{
    /**
     * Build petition for settlement search.
     * @param Int $zip_code
     * @return DBModelResponse
     */
    public function getSettlements($zip_code)
    {
        $query = 'SELECT';
        $query .= ' state.id as id_state,';
        $query .= ' state.name as federal_entity,';
        $query .= ' s.zipcode,';
        $query .= ' s.code settlement_key,';
        $query .= ' s.name settlement,';
        $query .= ' z.name zone_type,';
        $query .= ' st.name settlement_type,';
        $query .= ' c.code city_key,';
        $query .= ' c.name locality,';
        $query .= ' m.code municipality_key,';
        $query .= ' m.name municipality';
        $query .= ' FROM settlement s';
        $query .= ' INNER JOIN zone_type z ON (z.id=s.zone_id)';
        $query .= ' INNER JOIN settlement_type st ON (st.id=s.settlement_type_id)';
        $query .= ' INNER JOIN city c ON (c.id=s.city_id)';
        $query .= ' INNER JOIN state ON (state.id=c.state_id)';
        $query .= ' INNER JOIN municipality m ON (m.state_id=c.state_id) ';
        $query .= ' WHERE zipcode='. $zip_code;
        $query .= ' AND m.code=c.code_municipality';
        $query .= ' ORDER BY s.code';
        $response = $this->exec_query($query);
        return  $response;
    }
}
