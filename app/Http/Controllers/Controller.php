<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Response;
use App\Helpers\Util;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    //
    public function __construct(Request $req)
    {
        $this->req = $req;
    }
    public function show_data(){

        $res = new Response(__METHOD__);
        $data['parcels'] = DB::select("SELECT * FROM parcels  ");
        $res->set('OK', $data);
        $response = $res->get();
        return response()->json($response['content'], $response['status']);
    }
    public function show_data_by_month()
    {

        $res = new Response(__METHOD__);
        $data['parcels'] = DB::select("SELECT date_sub(date(now()), interval 1 month) FROM parcels GROUP BY month(created_at)");
        $res->set('OK', $data);
        $response = $res->get();
        return response()->json($response['content'], $response['status']);
    }
    public function get_data_by_year()
    {
        $res = new Response(__METHOD__);
        $data['parcels'] = DB::select("SELECT * FROM parcels WHERE year(created_at)=:years AND month(created_at)=:months ", [
            'years' => $this->req->input('year'),
            'months' => $this->req->input('month')
            // 'years' => '2022',
            // 'months' => '3'
        ]);
        $res->set('OK', $data);
        $response = $res->get();
        return response()->json($response['content'], $response['status']);
    }
    public function get_data_by_type()
    {
        $res = new Response(__METHOD__);
        $data['type_code'] = DB::select("SELECT type_code, count(type_code) FROM parcels  GROUP BY type_code ");
        $res->set('OK', $data);
        $response = $res->get();
        return response()->json($response['content'], $response['status']);
    }
    public function get_data_by_status()
    {
        //$type = '2022';
        //$mount='06';
        $res = new Response(__METHOD__);
        $data['return'] = DB::select("SELECT last_status_code, count(last_status_code)  FROM parcels  GROUP BY last_status_code ");
        $res->set('OK', $data);
        $response = $res->get();
        return response()->json($response['content'], $response['status']);
    }
    /**
     * It returns the sum of estimated_service_fee, other_fee, freight_fee, and
     * estimated_service_fee-freight_fee-other_fee for each courier_code.
     */
    public function get_data_all_payment()
    {
        //$type = '2022';
        //$mount='06';
        $res = new Response(__METHOD__);
        $data['payment'] = DB::select("SELECT courier_code,sum(estimated_service_fee),sum(other_fee),sum(freight_fee),sum(estimated_service_fee-freight_fee-other_fee) ,sum(estimated_service_fee-freight_fee-other_fee) * 100/(SELECT sum(estimated_service_fee) FROM parcels) as 'Percentage of Total' FROM parcels GROUP BY courier_code ");
        $res->set('OK', $data);
        $response = $res->get();
        return response()->json($response['content'], $response['status']);
    }
    public function get_data_all_payment_percent()
    {
        //$type = '2022';
        //$mount='06';
        $res = new Response(__METHOD__);
        $data['payment'] = DB::select("SELECT courier_code,sum(estimated_service_fee-freight_fee-other_fee),sum(estimated_service_fee-freight_fee-other_fee) * 100/(SELECT sum(estimated_service_fee-freight_fee-other_fee) FROM parcels) as 'Percentage of Total' From parcels GROUP BY courier_code ");
        $res->set('OK', $data);
        $response = $res->get();
        return response()->json($response['content'], $response['status']);
    }
    public function get_data_by_drop_code()
    {
        //$type = '2022';
        //$mount='06';
        $res = new Response(__METHOD__);
        $data['courier'] = DB::select("SELECT drop_code, count(drop_code) AS CountOf FROM parcels GROUP BY drop_code ");
        $res->set('OK', $data);
        $response = $res->get();
        return response()->json($response['content'], $response['status']);
    }
    public function get_data_all_courier()
    {
        //$type = '2022';
        //$mount='06';
        $res = new Response(__METHOD__);
        $data['courier'] = DB::select("SELECT courier_code, count(courier_code) AS CountOf FROM parcels GROUP BY courier_code ");
        $res->set('OK', $data);
        $response = $res->get();
        return response()->json($response['content'], $response['status']);
    }
    public function get_data_by_month()
    {
        //$type = '2022';
        //$mount='06';
        $res = new Response(__METHOD__);
        $data['month'] = DB::select("SELECT month(created_at),count(month(created_at)) FROM parcels GROUP BY month(created_at) ");
        $res->set('OK', $data);
        $response = $res->get();
        return response()->json($response['content'], $response['status']);
    }
}
