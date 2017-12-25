<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Musonza\Chat\Chat;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Chat $chat)
    {

        $data = [
            'conversations' => Auth::user()->conversations
        ];

        return view('entity.chat.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('entity.chat.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Chat $chat)
    {
        $user            = Auth::user();
        $conversation_id = $request->input('conversation');
        $conversation    = $chat->conversation($conversation_id);
        $chat->message($request->input('message'))->from($user->id)->to($conversation)->send();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Chat $chat)
    {
        $user = Auth::user();

        $conversation = $chat->conversation($id);

        //$conversation->readAll($user);

        $messages = $chat->conversations($conversation)->for($user)->getMessages(100, 0);

        $data = [
            'chat_messages' => $messages,
            'participants' => $conversation->users,
            'conversation' => $id
        ];

        return view('entity.chat.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
