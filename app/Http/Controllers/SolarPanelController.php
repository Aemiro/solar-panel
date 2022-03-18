<?php

namespace App\Http\Controllers;
use App\Repositories\SolarPanel\ISolarPanelRepository;
use Validator;

use Illuminate\Http\Request;

class SolarPanelController extends Controller
{
    private $solarPanelRepository;

    public function __construct(ISolarPanelRepository $solarPanelRepository)
    {
        $this->solarPanelRepository = $solarPanelRepository;
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->solarPanelRepository->getAll());
    }

    public function create(Request $request)
    {
try{
    $validator = Validator::make($request->all(),  [
        'model' => 'required|max:100',
        'price'=>'required|numeric',
        'manufactured_date'=>'date'
    ]);
    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }
$solarPanelAttributes=[
'model'=>$request->input('model'),
'price'=>$request->input('price'),
'description'=>$request->input('description'),
'category_id'=>$request->input('category_id'),
'manufactured_date'=>$request->input('manufactured_date'),
];
$solarPanel=$this->solarPanelRepository->create($solarPanelAttributes);
if($solarPanel){
    return response()->json($solarPanel);
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
        $solarPanel=$this->solarPanelRepository->getById($id);
        if($solarPanel==null){
            return response()->json(
                [
                    'message' => 'solarPanel not found',
                ], 404);
        }
        return response()->json($solarPanel);
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
        $solarPanel = $this->solarPanelRepository->getById($id);
        if($solarPanel==null){
            return response()->json(
                [
                    'message' => 'solarPanel not found',
                ], 404);
        }
        $validator = Validator::make($request->all(),  [
            'model' => 'required|max:100',
            'price'=>'required|numeric',
            'manufactured_date'=>'date'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $inputs = [
            'name' => $request->input('name'),
        ];
        return $this->solarPanelRepository->update($id, $inputs);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        if($this->solarPanelRepository->delete($id)){
            return response()->json("solarPanel Deleted", 200);
        }
        return response()->json("solarPanel not Deleted", 400);

    }
}
