<?php

namespace App\Http\Controllers;

use App\Events\ChatMessage;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Musonza\Chat\Chat;
use Musonza\Chat\Facades\ChatFacade;
use Musonza\Chat\Messages\Message;


class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Chat $chat, Request $request)
    {
        $user          = Auth::user();
        $conversations = $user->conversations;
        if ($conversations->count() == 1 and !$request->has('c')) {
            return redirect()->action('MessageController@index', ['c' => $conversations->first()->id]);
        }

        return view('entity.chat.index', [
            'conversations' => $conversations, 'has_conversations' => $conversations->isNotEmpty()
        ]);
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

        if (!$conversation->users()->where('users.id', $user->id)->first()) {
            return ['error'];
        }

        $message = $chat->message($request->input('message'))->from($user->id)->to($conversation)->send();

        broadcast(new ChatMessage($message));

        return ['sent'];
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

        if (!$conversation->users()->where('users.id', $user->id)->first()) {
            return ['error'];
        }

        $conversation->readAll($user);

        $messages = $conversation->messages()->orderBy('id', 'desc')->take(50)->get()->reverse();

        $data = [
            'chat_messages' => $messages,
            'participants' => $conversation->users,
            'conversation' => $id
        ];

        return view('entity.chat.show', $data);
    }

    public function read($id)
    {
        $user         = Auth::user();
        $conversation = ChatFacade::conversation($id);
        $conversation->readAll($user);

        return ['read'];
    }
}
