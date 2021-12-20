<?php

namespace App\Http\Controllers;
use \Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Products;

class CartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $data = DB::table('carts')
            ->where('user_id', Auth::id()) 
            ->where('cart_status',0)                        
            ->join('products', 'carts.pro_id', '=', 'products.id')
            ->join('users', 'carts.user_id', '=', 'users.id')
            ->select('carts.*', 'products.p_name', 'products.p_price', 'users.name', 'users.email', 'users.phone_no')
            ->get();
            
        return view('user.index')->with('data', $data);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->session()->has('key')) {
            $cart = new Cart;
            $cart->user_id = Auth::id();
            $cart->pro_id = $request->input('product_id');
            $cart->quantity = $request->input('quantity');
            //$ntoke = csrf_token();
            //return $request;
            $cart->save();
            return redirect('/');

        } else {
            return redirect('/login');
        }
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
        return $id;
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
    public function destroy($query)
    {

        //
    }

    public function remove($id)
    {
        return $id;
        /*
        $data = Cart::find($id);
        $data->delete();
        return redirect('/carts');
        */
    }

    public function search(Request $request)
    {
        
        if ($request->ajax()) {
            $output = "";
            $query = $request->get('query');
            if ($query != '') 
            {
                
                $products = DB::table('carts')
                ->join('products', 'carts.pro_id', '=', 'products.id')
                ->select('carts.*', 'products.p_name', 'products.p_price')
                ->where('products.p_name',$query)
                ->get();
            } else {                

                $products = DB::table('carts')
                ->where('user_id', Auth::id())
                ->join('products', 'carts.pro_id', '=', 'products.id')
                ->select('carts.*', 'products.p_name', 'products.p_price')
                ->get();

            }
            $total_row = $products->count();
            if ($total_row > 0) {
                foreach ($products as $index =>$row) {
                    $output .= '
                    <tr>
                        <td>'.($index+1).' </td>
                        <td>' . $row->p_name. '</td>
                        <td>' . $row->quantity. '</td>
                        <td>' . $row->p_price. '</td>                       
                        <td>
                            <a href="carts/'.$row->id.'"> Delete </a>
                        </td>                       
                        <td>
                            <a href="orders/'.$row->id.'"> Buy Now </a>
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

    public function clear()
    {
        
        DB::table('carts')->where('user_id', '=', Auth::id())->delete();
        return redirect('/carts');
    }

    public function test()
    {
        /*
        $products =  DB::table('carts')
            ->join('products', function ($join) {
                $join->on('carts.pro_id', '=', 'products.id')
                    ->where('products.p_name','second');
            })
            ->select('carts.*', 'products.p_name', 'products.p_price')
            ->get();

            $query = 'second';
            $order = DB::table('carts')
            ->join('products', 'carts.pro_id', '=', 'products.id')
            ->select('carts.*', 'products.p_name', 'products.p_price')
            ->where('products.p_name',$query)
            ->get();
        print_r($order);
        return $products;
        */
        $query = 'second';
        $products = DB::table('orders')
        ->join('products', 'orders.pro_id', '=', 'products.id')
        ->select('orders.*', 'products.p_name', 'products.p_price')
        ->where('products.p_name',$query)
        ->get();


        return $products;
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
        $userData->password = request('pwd');

        $userData->save();
        return json_encode(array('statusCode'=>200));
    }
      
      //catch exception
      catch(Exception $e) {
        return json_encode($e);
      }
}
    // End of main 
}