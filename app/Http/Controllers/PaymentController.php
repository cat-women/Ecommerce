<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use \App\Models\Payment;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return 'paymemnt ko create';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $payment = new Payment;  

        $payment->cart_id = $request->input('cart_id');
        $payment->pro_id = $request->input('pro_id');
        $payment->payment_id = $request->input('payment_id');
        $payment->amount = $request->input('amount');
        $payment->payment_mode = $request->input('payment_mode');
        $payment->email = $request->input('email');
        $payment->payment_status = $request->input('status');     

        $payment->save();   
           
        return response()->json([
            'status'=>'Payment successfull with paypal'
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    public function paypal(Request $request)
    {
        return $request;
        /*

        if ($request->ajax()) {
            $output = "";
            $query = $request->get('cart_id');
            if ($query != '') {
                return response()->json([
                    'status' => 'data received'
                ]);
            }else
            {
                return response()->json([
                    'status' => 'data not received'
                ]);
            }
        }
        */
    }


    //End of main
}
