<?php

namespace App\Http\Controllers;
use App\Repositories\product\IProductRepository;
use Validator;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(IProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
        $this->middleware('auth:api',['except' => ['getProducts']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->productRepository->getAll());
    }
 public function getProducts()
    {
        return response()->json($this->productRepository->getAll());
    }
    public function create(Request $request)
    {
try{
    $validator = Validator::make($request->all(),  [
        'model' => 'required|max:100',
        'price'=>'required|numeric',
        'name'=>'required|max:255',
        'category_id'=>'required'
    ]);
    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }
$productAttributes=[
'model'=>$request->input('model'),
'price'=>$request->input('price'),
'description'=>$request->input('description'),
'category_id'=>$request->input('category_id'),
'name'=>$request->input('name'),
];
$product=$this->productRepository->create($productAttributes);
if($product){
    return response()->json($product);
}
return response()->json(
    [
        'message' => "Unable to process your request, Please try again!",
        'type' => 'error',
    ], 400);
}catch (Exception $ex) {
            $msg = "Unable to process your request, Please try again!";
            return response()->json(
                [
                    'message' => $msg,
                    'type' => 'error',
                ], 400);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=$this->productRepository->getById($id);
        if($product==null){
            return response()->json(
                [
                    'message' => 'product not found',
                ], 404);
        }
        return response()->json($product);
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
        $product = $this->productRepository->getById($id);
        if($product==null){
            return response()->json(
                [
                    'message' => 'product not found',
                ], 404);
        }
        $validator = Validator::make($request->all(),  [
            'model' => 'required|max:100',
            'price'=>'required|numeric',
            'name'=>'required|max:255',
            'category_id'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $inputs = [
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'model' => $request->input('model'),
            'category_id'=>$request->input('category_id')



        ];
        return $this->productRepository->update($id, $inputs);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        if($this->productRepository->delete($id)){
            return response()->json("product Deleted", 200);
        }
        return response()->json("product not Deleted", 400);

    }
}
