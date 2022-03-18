<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return false|object|string
     */
    public function index($id)
    {
        return view('pages/companyProfile/Admin/AdminProductsPage', compact('id'));
    }

    public function addProductFile(Request $request)
    {
        $fileName = time() . rand() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('assets/sample/products'), $fileName);

        return response()->json(['file' => $fileName]);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'description' => 'required|string|max:255',
            'image' => 'required',
            'type' => 'required|string',
            'price' => 'required',
            'discount_price' => 'required',
        ]);
        return Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'company_id' => $request->id,
            'image' => $request->image,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'type' => $request->type
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $this->validate($request, [
            'title' => 'required|string',
            'description' => 'required|string|max:255',
            'image' => 'required',
            'type' => 'required|string',
            'price' => 'required',
            'discount_price' => 'required',
        ]);
        $product->title = $request->title;
        $product->description = $request->description;
        if ($product->image != $request->image) {
            $product->image = $request->image;
        }
        $product->type = $request->type;
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->save();
        return ['message' => 'record updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $categories = $product->categories()->get();
        foreach ($categories as $cat) {
            $cat->products()->detach($product);
        }
        $product->delete();
        return ['message' => 'record deleted'];
    }
}
