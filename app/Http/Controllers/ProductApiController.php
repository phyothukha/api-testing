<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $products = Product::latest('id')
            ->paginate(10);

        return response()->json($products);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name"=>"required|min:3|max:50",
            "price"=>"required|numeric|min:1",
            "stock"=>"required|numeric|min:1",
            "photos"=>'required',
            "photos.*"=>'file|mimes:jpg,jpeg,png|max:512',
        ]);

        $product= Product::create([
            "name"=>$request->name,
            'price'=>$request->price,
            'stock'=>$request->stock
        ]);

        $photos=[]
        foreach ($product->photos as $key=>$photo) {
            $newName= $photo->store('public');
            $photos[$key]= new Photo(['name'=>$newName]);
        }

        $product->photos()->saveMany($photos);


        return response()->json($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $products= Product::find($id);
        if(is_null($products)){
            return response()->json(['message'=>'product is not found'],404);
        }
        return $products;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name"=>"nullable|min:3|max:50",
            "price"=>"nullable|numeric|min:1",
            "stock"=>"nullable|numeric|min:1",

        ]);

        $product= Product::find($id);
        if(is_null($product)){
            return  response()->json(['message'=>'product is not found'],404);
        }


        if($request->has('name')){
        $product->name= $request->name;
        }
        if($request->has('price')){
        $product->price=$request->price;
        }
        if($request->has('stock')){
        $product->stock= $request->stock;
        }

        $product->update();

        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $products= Product::find($id);
        if(is_null($products)){
            return response()->json(['message'=>'product is not found'],404);
        }

        $products->delete();
        return response()->json(['message'=>'product is deleted'],204);
    }
}