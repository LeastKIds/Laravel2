<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{

    public function index() {
        return Inertia::render('Chat/container');
    }

    //
    /*
     *  1. 채팅방 리스트 리턴
     *  2. 특정 채팅 방의 메세지 리스트 리턴
     *  3. 특정 메세지 저장
     */

    public function rooms() {
        return ChatRoom::all();
    }

    public function messages($roomId) {
//        select * from chat_messages where room_id = ?
        $msgs =  ChatMessage::where('chat_room_id', $roomId)->with('user')-> latest() -> get(); // where('chat_room_id', '=', $roomId) 이지만 = 은 생략 가능
        // with('user') user 테이블과 함께 줘라
        //        lazy loading VS eager loading
//        dd($msgs);
//        $msgs[0] -> user -> name;
        return $msgs;
    }

    public function newMessage(Request $request, $roomId) {
        $request -> validate(['message' => 'required']);

        $msg = ChatMessage::create([
            'user_id' => auth() -> user() -> id,
            'chat_room_id' => $roomId,
            'message' => $request -> message,
        ]);

        broadcast(new NewChatMessage($msg -> chat_room_id) ) -> toOthers();

        return $msg;
    }


}
