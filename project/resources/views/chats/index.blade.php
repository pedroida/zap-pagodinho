@extends('layouts.app', ['activePage' => 'chats', 'titlePage' => __('phrases.chats')])

@section('content')
    <chat-container
            friends-url="{{ route('friends.index') }}"
            my-chats-url="{{ route('ajax.my-chats') }}"
            new-chat-url="{{ route('ajax.chat.create') }}"
            new-chats-available-url="{{ route('ajax.chats.available') }}">
    </chat-container>
@endsection
