<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
           'email'=>'required|unique:users',
           'password'=> 'required|min:8'
        ],[],[
            'email'=>'البريد الإلكتروني',
            'password'=>'كلمة المرور'
        ]);

        if ($validator->fails()){
            $data = $validator->errors();
            $msg = 'تأكد من البيانات المدخلة';
            return response()->json(compact('msg','data'),422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(['msg'=>'تمت عملية الإضافة بنجاح']);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'=>'required',
            'password'=>'required'
        ],[],[
            'email'=>'البريد الإلكتروني',
            'password'=>'كلمة المرور'
        ]);

        if ($validator->fails()){
            $msg = 'تأكد من البيانات المدخلة';
            $data = $validator->errors();
            return response()->json(compact('msg','data'),422);
        }

        $user = User::where('email',$request->email)->first();

        if (!$user){
            return response()->json(['هذا اللإيميل غير موخود'],401);
        }

        if (Hash::check($request->password,$user->password)){
            $token =$user->createToken('Laravel password Grant Clint');
            $response =['token'=>$token];
            return response($response,200);
        }else{
            $response = ['message'=>'خطأ في كلمة المرور'];
            return response($response,422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
}
