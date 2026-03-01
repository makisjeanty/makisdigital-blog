<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:newsletters,email',
        ], [
            'email.unique' => 'Este e-mail já está em nossa lista!',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
        ]);

        Newsletter::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Inscrição realizada com sucesso! Prepare-se para o futuro.',
            ]);
        }

        return back()->with('success', 'Inscrição realizada com sucesso! Prepare-se para o futuro.');
    }
}
