<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReviewModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ReviewController extends Controller
{
    public function index(Request $request){
        switch (true) {
            case $request->isMethod('GET'):
                $data['reviews'] = ReviewModel::where([['status', '!=', 'D']])->latest()->paginate(10);
                return view('admin.panel.review.index', @$data);
            break;

            case $request->isMethod('POST'):
                $rules = [
                    'content' => 'required',
                    'rating' => 'required'
                ];        
                $validator = Validator::make($request->all(), $rules);
                if($validator->fails()){
                    $validator->errors()->add('review_err', '1');
                    $validator->errors()->add('review_err_rowid', base64_encode(@$request->rowid));
                    return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
                }else{
                    $user = Auth::user();
                    if(ReviewModel::updateOrCreate(['id' => @$request->rowid], [
                        'user_id' => $user->id,
                        'user_id' => $user->name,
                        'content' => $request->content,
                        'rating' => $request->rating
                    ])){
                        return redirect()->back()->withSuccess('Review added successfully.');
                    }
                    return redirect()->back()->withError('Soemthing went wrong.');
                }
            break;

            default:
                abort(403, 'Unauthorized action.');
            break;
        }
    }

    public function getsinglerow($rowid){
       
        $rowid = $rowid != null? base64_decode($rowid) : null;
        if($rowid != null){
            if($data = ReviewModel::where([['id', '=', $rowid]])->first()){
                return response()->json(['code' => 200, 'data' => $data]);
            }
            return response()->json(['code' => 500]); 
        }
        return response()->json(['code' => 500]);
    }
}
