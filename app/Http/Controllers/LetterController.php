<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;

class LetterController extends Controller
{
    public function preview($id) {
        $template = Template::findOrFail($id);
        return view('preview', ['content' => $template->letter_body]);
    }
}

