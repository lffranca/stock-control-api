<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Product;

class ProductController extends Controller
{
    public function index(Request $request, $offset, $limit)
    {
        $all = Product::count();
        $products = Product::skip($offset)->take($limit)->get();

        return [
            'items' => $products,
            'total' => $all
        ];
    }

    public function search(Request $request)
    {
        $query = $request->query('search');

        if (empty($query)) {
            return [];
        }

        $products = Product::where('brand', 'LIKE', '%'.$query.'%')
            ->orWhere('volume', 'LIKE', '%'.$query.'%')
            ->orWhere('unit_value', 'LIKE', '%'.$query.'%')
            ->orWhere('quantity', 'LIKE', '%'.$query.'%')
            ->get();

        return $products;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand' => 'required|string|max:30',
            'volume' => 'required|in:250ml,600ml,1l',
            'type' => 'required|in:PET,GARRAFA,LATA',
            'quantity' => 'required|numeric',
            'unit_value' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product = new Product;

        $product->brand = $request->input('brand');
        $product->volume = $request->input('volume');
        $product->type = $request->input('type');
        $product->quantity = $request->input('quantity');
        $product->unit_value = $request->input('unit_value');

        if (!$product->save()) {
            return response()->json(['message' => 'Save error!'], 400);
        }

        return $product;
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'brand' => 'required|string|max:30',
            'volume' => 'required|in:250ml,600ml,1l',
            'type' => 'required|in:PET,GARRAFA,LATA',
            'quantity' => 'required|numeric',
            'unit_value' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product = Product::find($id);

        $product->brand = $request->input('brand');
        $product->volume = $request->input('volume');
        $product->type = $request->input('type');
        $product->quantity = $request->input('quantity');
        $product->unit_value = $request->input('unit_value');

        if (!$product->save()) {
            return response()->json(['message' => 'Update error!'], 400);
        }

        return $product;
    }

    public function destroy($id)
    {
        if (!Product::destroy($id)) {
            return response()->json(['message' => 'ID not exist'], 400);
        }

        return ['message' => 'Delete success!'];
    }

    public function destroy_all(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $ids = $request->input('ids');

        if (!Product::destroy($ids)) {
            return response()->json(['message' => 'IDs not exist'], 400);
        }

        return ['message' => 'Delete success!'];
    }
}
