<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
class CommentController extends Controller
{
   

    public function index()
    {
        $comments = Comment::with(['user', 'company', 'employee'])->orderBy('created_at', 'desc')->get();
        return view('comments.index', compact('comments'));
    }
    
}
