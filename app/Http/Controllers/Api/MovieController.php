<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\DateTime;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movie = Movie::all();
        return response()->json($movie);
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
            'category_id'=>'required',
            'name'=>'required|unique:movies',
            'show_time'=>'required'
        ],[],[
            'category_id'=>'نوع التصنيف',
            'name'=>'الأسم',
            'show_time'=>'وقت العرض'
        ]);

        if ($validator->fails()){
            $msg = 'تأكد من البيانات المدخلة';
            $data = $validator->errors();
            return response()->json(compact('msg','data'),422);
        }

        $movie = new Movie();
        $movie->category_id = $request->category_id;
        $movie->name = $request->name;
        $movie->show_time = $request->show_time;
        $movie->save();
        return response()->json(['msg','تمت عملية الإضافة بنجاح']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Movie::find($id);
        return response()->json($movie);
    }

    public function searchMovieName($name)
    {
        $movie = Movie::where('name','like','%'.$name.'%')->first();
        return response()->json($movie);
    }
    public function searchMovieDate($date)
    {
        $movie = Movie::where('show_time','like','%'.$date.'%')->first();
        return response()->json($movie);
    }
    public function MovieDaye()
    {
        $mytime = Carbon::now();
//        dd($mytime->toDateTimeString());
//        dd(date("d"));
//        dd(Carbon::now()->day);
//        $movie = Movie::where('show_time','like','%'.Carbon::now()->day.'%')->first();
        $movie = Movie::where('show_time','like','%'.date("d").'%')->first();
        return response()->json($movie);
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
        $validator = Validator::make($request->all(),[
            'category_id'=>'sometimes',
            'name'=>'sometimes|unique:movies,name,'.$id,
            'show_time'=>'sometimes'
        ],[],[
            'category_id'=>'نوع التصنيف',
            'name'=>'الأسم',
            'show_time'=>'وقت العرض'
        ]);

        if ($validator->fails()){
            $msg = 'تأكد من البيانات المدخلة';
            $data = $validator->errors();
            return response()->json(compact('msg','data'),422);
        }

        $movie = Movie::find($id);
        if ($request->category_id){
            $movie->category_id = $request->category_id;
        }
        if ($request->name){
            $movie->name = $request->name;
        }
        if ($request->show_time){
            $movie->show_time = $request->show_time;
        }
        $movie->save();
        return response()->json(['msg','تمت عملية التعديل بنجاح']);
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
