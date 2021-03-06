<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::paginate(15);
        $iteration = ($comments->currentPage()-1) * $comments->perPage();

        return view('admin.comments.index',compact('comments','iteration'));
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
    public function store(Request $request,product $product)
    {
        $request->validate([
            'body'=>'required|string|max:500'
        ]);

        $product->comments()->create([
            'user_id'=>$request->user()->id,
            'body'=>$request->body
        ]);

        return back()->with(['message'=>'نظر شما با موفقیت ثبت شد و پس از تایید مدیر نمایش داده میشود!']);
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
    public function activate(Request $request,Comment $comment)
    {
        $comment->update([
            'status'=>'Active'
        ]);
        return back()->with(['message'=>'نظر با موفقیت فعال شد!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        if (Gate::allows('delete',$comment)){
            $comment->delete();
            return back()->with(['message'=>'نظر با موفقیت حذف شد!']);
        }else{
            abort(403);
        }
    }


    public function inactiveCommentsIndex(){
        $comments = Comment::where('status','=','Inactive')->paginate(15);
        $iteration = ($comments->currentPage() - 1) * $comments->perPage();

        return view('admin.comments.inactivecomments',compact('comments','iteration'));
    }
}
