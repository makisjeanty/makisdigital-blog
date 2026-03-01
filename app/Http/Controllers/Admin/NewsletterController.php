<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;

class NewsletterController extends Controller
{
    public function index()
    {
        $subscribers = Newsletter::latest()->paginate(20);

        return view('admin.newsletters.index', compact('subscribers'));
    }

    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();

        return back()->with('success', 'Inscrito removido com sucesso.');
    }
}
