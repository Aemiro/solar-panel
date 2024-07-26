<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Order\IOrderRepository;
use Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
class OrderController extends Controller
{
    private $orderRepository;
   // protected $user;
    public function __construct(IOrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->orderRepository->getAll());
    }

    public function create(Request $request)
    {
try{
    $validator = Validator::make($request->all(),  [
        'description' => 'required',
        'customer_id' => 'required',
    ]);
    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }
$orderAttributes=[
'description'=>$request->input('description'),
'customer_id'=>$request->input('customer_id'),


];
$order=$this->orderRepository->create($orderAttributes);
if($order){
    return response()->json($order);
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
        $order=$this->orderRepository->getById($id);
        if($order==null){
            return response()->json(
                [
                    'message' => 'Order not found',
                ], 404);
        }
        return response()->json($order);
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
        $order = $this->orderRepository->getById($id);
        if($order==null){
            return response()->json(
                [
                    'message' => 'Order not found',
                ], 404);
        }
        $validator = Validator::make($request->all(),  [
            'description' => 'required',
            'customer_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $inputs = [
            'description' => $request->input('description'),
            'customer_id'=>$request->input('customer_id'),
        ];
        return $this->orderRepository->update($id, $inputs);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        if($this->orderRepository->delete($id)){
            return response()->json("Order Deleted", 200);
        }
        return response()->json("Order not Deleted", 400);

    }
}
