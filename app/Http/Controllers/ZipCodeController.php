<?php

namespace App\Http\Controllers;

use App\Models\ZipCodeModel;

class ZipCodeController extends Controller
{
    public function serachZipCode($zip_code)
    {
        if (!is_numeric($zip_code)) {
            return [
                'ok' => true,
                'message' => 'Invalid zip code.'
            ];
        }
        $model = new ZipCodeModel();
        $response = $model->serachZipCode($zip_code);
        if($response['status']){
            $response = $this->customResponse($response['data']);
        }
        return response()->json($response);
    }

    public function customResponse($data){
        $response = [
            'zip_code' => '',
            'locality' => '',
            'federal_entity' => [],
            'settlements' => [],
            'municipality' => []
        ];
        foreach($data as $key => $value){
            if(!$response['zip_code']){
                $response['zip_code'] = $value['zipcode'];
                $response['locality'] = strtoupper($value['locality']);
                $response['federal_entity'] = [
                    'key' => (int)$value['id_state'],
                    'name' => strtoupper($value['federal_entity']),
                    'code' => null
                ];
                $response['municipality'] = [
                    'key' => (int)$value['municipality_key'],
                    'name' => strtoupper($value['municipality'])
                ];
            }
            $response['settlements'][] = [
                'key' => (int)$value['settlement_key'],
                'name' => strtoupper($value['settlement']),
                'zone_type' => $value['zone_type'],
                'settlement_type' => ['name' => $value['settlement_type']]
            ];
        }
        return $response;
    }
}
