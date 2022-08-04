<?php

namespace App\Http\Controllers;

use App\Models\ZipCodeModel;

class ZipCodeController extends Controller
{
    /**
     * Search for the settlements that belong to the zip code provided.
     * @param int $zip_code
     * @return JsonResponse
     */
    public function getSettlements($zip_code)
    {
        if (!is_numeric($zip_code)) {
            return [
                'ok' => true,
                'message' => 'Invalid zip code.'
            ];
        }
        $model = new ZipCodeModel();
        $response = $model->getSettlements($zip_code);
        if($response['status']){
            $response = $this->customResponse($response['data']);
        }
        return response()->json($response);
    }

    /**
     * Standardize the format of my response.
     * @param Array $data 
     * @return Array
     */
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
