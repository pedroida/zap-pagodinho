@extends('layouts.app', ['activePage' => 'chats', 'titlePage' => __('phrases.chats')])

@section('content')
    <chat-container
            send-message-url="{{ route('ajax.message.send') }}"
            friends-url="{{ route('friends.index') }}"
            my-chats-url="{{ route('ajax.my-chats') }}"
            new-chat-url="{{ route('ajax.chat.store') }}"
            delete-chat-url="{{ route('ajax.chat.destroy', ':chat_id') }}"
            leave-chat-url="{{ route('ajax.chat.leave', ':chat_id') }}"
            new-chats-available-url="{{ route('ajax.chats.available') }}">
    </chat-container>
@endsection
