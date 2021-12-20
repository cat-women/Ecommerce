<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;
use App\Models\Products;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $product = new Products;
        $product->p_name = $request->name;
        $product->p_desc = $request->description;
        $product->p_price = $request->price;

        $product->p_cat = $request->cat;
        $product->p_tag = $request->tagList;
        $product->is_avail = $request->isAvail;


        // Image storing 
        if ($request->hasFile('image')) {
            $fileExt = $request->file('image')->getClientOriginalName();
            $fileName = pathinfo($fileExt, PATHINFO_FILENAME);
            $ext = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore  = $fileName . '_' . time() . '.' . $ext;
            $path = $request->file('image')->storeAs('public/productImage', $fileNameToStore);
        } else {
            $fileNameToStore = 'noImage.jpg';
        }

        $product->image = $fileNameToStore;

        $product->save();
        redirect('/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Products::find($id);
        return view('front.product')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Products::find($id);
        return $product;
        //return json_encode(array('data'=>$userData));
        echo json_encode($product);
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
        $product = Products::find($id);
        if ($product != '') {
            try {
                $product->p_name = $request->name;
                $product->p_desc = $request->desc;
                $product->p_price = $request->price;

                $product->p_cat = $request->cat;
                //$product->p_tag = $product->tagList;
                $product->is_avail = $request->isAvail;


                // Image storing 
                if ($request->hasFile('image')) {
                    $path = '/storage/productImage/'.$product->image;
                    if(File::exists($path))
                    {
                        File::delete($path);
                    }

                    $fileExt = $request->file('image')->getClientOriginalName();
                    $fileName = pathinfo($fileExt, PATHINFO_FILENAME);
                    $ext = $request->file('image')->getClientOriginalExtension();
                    $fileNameToStore  = $fileName . '_' . time() . '.' . $ext;
                    
                    $file->move('/storage/productImage/',$fileNameToStore);

                } else {
                    $fileNameToStore = 'noImage.jpg';
                }

                $product->image = $fileNameToStore;

                $product->update();
                return json_encode("Data updated successfully ");

            }
            //catch exception
            catch (Exception $e) {
                return json_encode($e);
            }
        } else {
            return json_encode("data not found");
        }
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

    public function main()
    {
        $products = Products::all();
        //return $products;
        return view('front.index')->with('products', $products);
    }

    // Search 

    public function searchProduct(Request $request)
    {
        try {
            $query = $request->get('query');
            if ($query != '') {
                $products = DB::table('products')
                    ->select('p_name', 'id', 'p_cat')
                    ->where('p_name', 'like', '%' . $query . '%')
                    ->orWhere('p_cat', 'like', '%' . $query . '%')
                    ->orderBy('p_name')
                    ->get();
            }

            if ($products != '') {
                echo json_encode($products);
            } else {
                $res = '1 Data not found';
                echo json_encode('Data not found');
            }
        } catch (Exception $e) {
            echo json_encode($e);
        }
    }
}
