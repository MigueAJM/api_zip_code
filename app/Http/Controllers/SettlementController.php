<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settlement;

class SettlementController extends Controller
{
    /**
     * Returns a json with the settlements that correspond
     * to the zip code received.
     * @param Int $zip_code
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
        $model = new Settlement();
        $zip = new ZipCodeController();
        $response = $model->getSettlements($zip_code);
        if($response['status']){
            $response = $zip->customResponse($response['data']);
        }
        return response()->json($response);
    }
}
