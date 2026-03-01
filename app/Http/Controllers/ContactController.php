<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;

class ContactController extends Controller
{
    public function store(StoreMessageRequest $request)
    {
        $validated = $request->validated();

        Message::create($validated);

        return back()->with('success', 'Sua mensagem foi enviada com sucesso! Entraremos em contato em breve.');
    }

    public function index()
    {
        $messages = Message::latest()->paginate(15);

        return view('admin.messages.index', compact('messages'));
    }

    public function show(Message $message)
    {
        $message->update(['is_read' => true]);

        return view('admin.messages.show', compact('message'));
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'Mensagem deletada.');
    }
}
