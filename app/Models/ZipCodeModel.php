<?php

namespace App\Models;

class ZipCodeModel extends DBModel
{
    public function serachZipCode(int $zip_code)
    {
        $query = 'SELECT';
        $query .= ' state.id_state,';
        $query .= ' state.name as federal_entity,';
        $query .= ' s.zip_code,';
        $query .= ' s.code settlement_key,';
        $query .= ' s.name settlement,';
        $query .= ' z.name zone_type,';
        $query .= ' st.name settlement_type,';
        $query .= ' c.code city_key,';
        $query .= ' c.name locality,';
        $query .= ' m.code municipality_key,';
        $query .= ' m.name municipality';
        $query .= ' FROM settlement s';
        $query .= ' INNER JOIN zone_type z ON (z.id_zone=s.id_zone)';
        $query .= ' INNER JOIN settlement_type st ON (st.id_settlement_type=s.id_settlement_type)';
        $query .= ' INNER JOIN city c ON (c.id_city=s.code_city)';
        $query .= ' INNER JOIN state ON (state.id_state=c.id_state)';
        $query .= ' INNER JOIN municipality m ON (m.id_state=c.id_state) ';
        $query .= ' WHERE zip_code='. $zip_code;
        $query .= ' AND m.code=c.code_municipality';
        $query .= ' ORDER BY s.code';
        $response = $this->exec_query($query);
        return  $response;
    }
}
