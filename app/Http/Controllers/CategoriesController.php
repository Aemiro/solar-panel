<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Category\ICategoryRepository;
use Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
class CategoriesController extends Controller
{
    private $categoryRepository;
   // protected $user;
    public function __construct(ICategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->middleware('auth:api');
     //   $this->user = JWTAuth::parseToken()->authenticate();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->categoryRepository->getAll());
    }

    public function create(Request $request)
    {
try{
    $validator = Validator::make($request->all(),  [
        'name' => 'required|max:100',
    ]);
    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }
$categoryAttributes=[
'name'=>$request->input('name')
];
$category=$this->categoryRepository->create($categoryAttributes);
if($category){
    return response()->json($category);
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
        $category=$this->categoryRepository->getById($id);
        if($category==null){
            return response()->json(
                [
                    'message' => 'Category not found',
                ], 404);
        }
        return response()->json($category);
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
        $category = $this->categoryRepository->getById($id);
        if($category==null){
            return response()->json(
                [
                    'message' => 'Category not found',
                ], 404);
        }
        $validator = Validator::make($request->all(),  [
            'name' => 'required|max:100',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $inputs = [
            'name' => $request->input('name'),
        ];
        return $this->categoryRepository->update($id, $inputs);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        if($this->categoryRepository->delete($id)){
            return response()->json("Category Deleted", 200);
        }
        return response()->json("Category not Deleted", 400);

    }
}
