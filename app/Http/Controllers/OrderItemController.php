<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\OrderItem\IOrderItemRepository;
use Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
class OrderItemController extends Controller
{
    private $orderItemRepository;
   // protected $user;
    public function __construct(IOrderItemRepository $orderItemRepository)
    {
        $this->orderItemRepository = $orderItemRepository;
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->orderItemRepository->getAll());
    }

    public function create(Request $request)
    {
try{
    $validator = Validator::make($request->all(),  [
        'quantity' => 'required',
        'product_id' => 'required',
        'order_id' => 'required',

    ]);
    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }
$orderItemAttributes=[
'remark'=>$request->input('remark'),
'product_id'=>$request->input('product_id'),
'order_id'=>$request->input('order_id'),

'price'=>$request->input('price'),
'quantity'=>$request->input('quantity'),

];
$orderItem=$this->orderItemRepository->create($orderItemAttributes);
if($orderItem){
    return response()->json($orderItem);
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
        $orderItem=$this->orderItemRepository->getById($id);
        if($orderItem==null){
            return response()->json(
                [
                    'message' => 'Order not found',
                ], 404);
        }
        return response()->json($orderItem);
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
        $orderItem = $this->orderItemRepository->getById($id);
        if($orderItem==null){
            return response()->json(
                [
                    'message' => 'Order not found',
                ], 404);
        }
        $validator = Validator::make($request->all(),  [
            'product_id' => 'required',
            'order_id' => 'required',
            'price' => 'required',
            'quantity' => 'required',


        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $inputs = [
            'quantity' => $request->input('quantity'),
            'product_id'=>$request->input('product_id'),
            'remark' => $request->input('remark'),
            'order_id'=>$request->input('order_id'),
        ];
        return $this->orderItemRepository->update($id, $inputs);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        if($this->orderItemRepository->delete($id)){
            return response()->json("Order Item Deleted", 200);
        }
        return response()->json("Order Item not Deleted", 400);

    }
}
