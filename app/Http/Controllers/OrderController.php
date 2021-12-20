<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use \App\Models\Products;
use \App\Models\Cart;

use \App\Models\Order;
use \Illuminate\Support\Facades\Auth;

class OrderController extends Controller
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
    public function orderIndex($id)
    {
        $check = DB::table('carts')
            ->where('user_id', Auth::id())->where('carts.id', $id)
            ->first();
        if ($check == null) {
            try {

                $cart = new Cart;
                $cart->user_id = Auth::id();
                $cart->pro_id = $id;
                $cart->cart_status = 1;
                $cart->save();
            } catch (Exception $e) {
                echo $e;
            }
        }

        $temp = DB::table('carts')->where('pro_id', $id)->first();
        $id = $temp->id;

        $product = DB::table('carts')
            ->join('products', 'carts.pro_id', '=', 'products.id')
            ->join('users', 'carts.user_id', '=', 'users.id')
            ->select('carts.*', 'products.p_name', 'products.p_price', 'users.name', 'users.email', 'users.phone_no')
            ->where('carts.id', $id)
            ->orderBy('updated_at', 'desc')
            ->latest()
            ->first();

        if ($product == NULL) {
            return 'Internal sever Error ';
        } else {
            return view('order.order')->with('product', $product);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('order.order');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $order = new Order;

        $order->cart_id = $request->cart_id;
        $order->user_id = Auth::id();
        $order->pro_id = $request->pro_id;
        $order->o_quantity = $request->quantity;
        $order->address = $request->address;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->payment_type = $request->payment_type;


        $order->save();

        return redirect('/carts');
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

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $query = $request->get('query');
            if ($query != '') {

                $products = DB::table('orders')
                    ->join('products', 'orders.pro_id', '=', 'products.id')
                    ->select('orders.*', 'products.p_name', 'products.p_price')
                    ->where('products.p_name', $query)
                    ->get();
            } else {
                $products = DB::table('orders')
                    ->where('orders.user_id', Auth::id())
                    ->join('products', 'orders.pro_id', '=', 'products.id')
                    ->select('orders.*', 'products.p_name', 'products.p_price')
                    ->get();
            }

            $total_row = $products->count();
            if ($total_row > 0) {
                foreach ($products as $index => $row) {
                    $output .= '
                    <tr>
                        <td>' . ($index + 1) . ' </td>
                        <td>' . $row->p_name . '</td>
                        <td>' . $row->o_quantity . '</td>
                        <td>' . $row->p_price . '</td>                       
                        <td>
                            <a href="carts/' . $row->o_id . '"> Delete </a>
                        </td>                       
                        <td>
                            <a href="orders/' . $row->pro_id . '"> Buy Now </a>
                        </td>
                    </tr>
                    ';
                }
            } else {
                $output = '
            <tr>
                <td align="center" colspan="5">No Data Found</td>
            </tr>
            ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );

            echo json_encode($data);
        }
    }




    //End of class
}
