<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Products;
use App\Models\User;
use App\Models\Order;


class AdminController extends Controller
{
    public function index()
    {
        $product = DB::table('orders')
            ->join('products', 'orders.pro_id', '=', 'products.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('products.p_name', DB::raw('sum(orders.o_quantity) as total'))
            ->groupBy('products.p_name')
            ->get();

        $user = DB::table('users')
            ->select('role', DB::raw('count(users.id) as totaluser'))
            ->groupBy('role')
            ->get();

        $data =  DB::table('orders')
            ->select('orders.created_at', DB::raw('sum(orders.o_quantity) as total'), DB::raw('DAYOFMONTH(orders.created_at) as day'))
            ->groupBy(DB::raw('DAYOFMONTH(orders.created_at)'))
            ->get();

        $data = array($product, $user, $data);
        //print_r($data);
        //return $data;
        return view('dashboard.index')->with('product', $data);
    }

    // product
    public function product()
    {
        $products = DB::table('products')->paginate(15);
        return view('dashboard.product')->with('products', $products);
    }

    //Order
    public function order()
    {
        /*
        $orders = DB::table('orders')
            ->join('payments', 'orders.cart_id', '=', 'payments.cart_id')
            ->join('products', 'orders.pro_id', '=', 'products.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'products.p_name', 'products.p_price', 'users.name', 'payments.payment_status as status', 'payments.payment_mode as mode', 'payments.payment_id')
            ->paginate(15);
        */

        $orders = DB::table('payments')
            ->join('orders', 'payments.cart_id', '=', 'orders.cart_id')
            ->join('products', 'orders.pro_id', '=', 'products.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'products.p_name', 'products.p_price', 'users.name', 'payments.payment_status as status', 'payments.payment_mode as mode', 'payments.payment_id')
            ->paginate(15);
        
        return view('dashboard.order')->with('orders', $orders);
        
    }

    //user 
    public function user()
    {
        $users = DB::table('users')->paginate(15);
        return view('dashboard.user')->with('users', $users);
    }

    // edit user 
    public function editUser($id)
    {
        $userData = User::find($id);
        return $userData;
        //return json_encode(array('data'=>$userData));
        echo json_encode($userData);
    }

    //Update user 

    public function updateUser($id)
    {
        try {
            $userData = User::find($id);

            $userData->name = request('name');
            $userData->email = request('email');
            $userData->phone_no = request('phone');
            $userData->address = request('address');
            $userData->role = request('role');

            $userData->save();
            return json_encode(array('statusCode'=>200));
        }
          
          //catch exception
          catch(Exception $e) {
            return json_encode($e);
          }
    }

    //Delete user

    public function deleteUser($id)
    {
        try{
       User::find($id)->delete();        
        return json_encode(array('statusCode'=>200));
        }
        catch(Exception $e){
            return json_encode('Data not found ');
        }
       
    }


    public function productAvail(Request $request)
    {
        if ($request->ajax()) {
            $product = DB::table('products')
                ->select('p_name', DB::raw('count(p_name) as total'))
                ->groupBy('p_name')
                ->where('is_avail', 1)
                ->get();
            echo json_encode($product);
        }
    }




    public function test()
    {
        /*
           $cat = DB::table('orders')
            ->join('products', 'orders.pro_id', '=', 'products.id')
            ->select('products.p_cat')
            ->groupBy('products.p_cat')
            ->get();
           // print_r($cat);

        $data = array();


        for($i = 0; $i< (count($cat));  $i++)
        {
            $data[$cat[$i]->p_cat] = DB::table('orders')
                ->join('products', 'orders.pro_id', '=', 'products.id')
                ->select('orders.created_at',DB::raw('sum(orders.o_quantity) as total'),DB::raw('DAYOFMONTH(orders.created_at) as day'),DB::raw('MONTH(orders.created_at) as month'))
                ->groupBy(DB::raw('DAYOFMONTH(orders.created_at)'))
                ->where('products.p_cat',$cat[$i]->p_cat)
                ->get();
        }
        */
        $data = DB::table('orders')
        ->join('payments', 'orders.cart_id', '=', 'payments.cart_id')
        ->select('orders.*','payments.*')
        ->get();


        $orders = DB::table('payments')
            ->join('products', 'payments.pro_id', '=', 'products.id')
            ->join('orders', 'payments.cart_id', '=', 'orders.cart_id')            
            ->select('payments.id as pay_id','orders.cart_id as cart_id', 'products.p_name', 'products.p_price','payments.payment_status as status', 'payments.payment_mode as mode', 'payments.payment_id')
            ->orderBy('payments.id')
            ->get();



        echo '<pre>';
        print_r($orders);
        echo '</pre>';
        //return $data;
        return view('dashboard.test')->with('data', $data);
    }


    // End of class
}
