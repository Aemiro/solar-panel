<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Customer\ICustomerRepository;
use Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
class CustomerController extends Controller
{
    private $customerRepository;
   // protected $user;
    public function __construct(ICustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->customerRepository->getAll());
    }

    public function create(Request $request)
    {
try{
    $validator = Validator::make($request->all(),  [
        'name' => 'required|max:100',
        'email' => 'required|max:100',
        'phone' => 'required|max:15',
        'gender' => 'required',
    ]);
    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }
$customerAttributes=[
'name'=>$request->input('name'),
'email'=>$request->input('email'),
'phone'=>$request->input('phone'),
'gender'=>$request->input('gender')


];
$customer=$this->customerRepository->create($customerAttributes);
if($customer){
    return response()->json($customer);
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
        $customer=$this->customerRepository->getById($id);
        if($customer==null){
            return response()->json(
                [
                    'message' => 'Customer not found',
                ], 404);
        }
        return response()->json($customer);
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
        $customer = $this->customerRepository->getById($id);
        if($customer==null){
            return response()->json(
                [
                    'message' => 'Customer not found',
                ], 404);
        }
        $validator = Validator::make($request->all(),  [
            'name' => 'required|max:100',
            'email' => 'required|max:100',
            'phone' => 'required|max:15',
            'gender' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $inputs = [
            'name' => $request->input('name'),
            'email'=>$request->input('email'),
            'phone'=>$request->input('phone'),
            'gender'=>$request->input('gender')
        ];
        return $this->customerRepository->update($id, $inputs);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        if($this->customerRepository->delete($id)){
            return response()->json("Customer Deleted", 200);
        }
        return response()->json("Customer not Deleted", 400);

    }
}
