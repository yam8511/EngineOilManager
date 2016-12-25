<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Oil;
use Log;
use Storage;
use Validator;

class OilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $oils = Oil::all();

        $data['oils'] = $oils->toArray();
        foreach ($oils as $index => $oil) {
            $filename = $oil->name . '_' . date('Y-m-d_H-i-s', strtotime($oil->datetime)) . '.jpg';
            $data['oils'][$index]['photo'] = $filename;

            $exist = Storage::disk('public')->has($filename);
            if (!$exist) {
                $img = base64_decode($oil->photo);
                Storage::disk('public')->put($filename, $img);
            }
            $data['oils'][$index]['photo'] = url(Storage::disk('public')->url($filename));
        }
        return view('index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'count' => 'required|integer',
            'photo' => 'file|image|max:5000',
        ], [
            'required' => ':attribute 該欄位必須填',
            'file' => ':您上傳的東西不是檔案',
            'image' => ':您上傳的檔案實質須為圖片格式',
            'max' => ':您上傳的檔案不能超過 5MB'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'result' => 'error',
                'msg' => $validator->messages(),
            ]);
        }

        $datetime = date('Y-m-d H:i:s');
        $path = '';

        if ($request->hasFile('photo')) {
            $filename = $request->input('name') . '_' . date('Y-m-d_H-i-s', strtotime($datetime)) . '.jpg';
            $path = $request->file('photo')->storeAs('.', $filename, 'public');
        }

        $oil = new Oil();
        $oil->name = $request->input('name');
        $oil->count = $request->input('count');
        $oil->photo = $request->hasFile('photo') ? base64_encode(Storage::disk('public')->get($path)) : null;
        $oil->datetime = $datetime;
        if (!$oil->save()) {
            return response()->json([
                'result' => 'error',
                'msg' => '系統錯誤'
            ]);
        }

        return response()->json([
            'result' => 'ok'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Oil $oil)
    {
        $validator = Validator::make($request->all(), [
            'count' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'result' => 'error',
                'msg' => '數量有問題'
            ]);
        }

        $oil->count = $request->input('count');
        if (!$oil->save()) {
            return response()->json([
                'result' => 'error',
                'msg' => '系統錯誤',
            ]);
        }

        return response()->json([
            'result' => 'ok',
            'count' => $request->input('count'),
            'msg' => '數量修改成功',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Oil $oil)
    {
        $oil->delete();
        return redirect('/');
    }
}
