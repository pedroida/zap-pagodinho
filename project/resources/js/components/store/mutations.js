export default {
  SET_MY_CHATS_URL: (state, url) => state.urls.myChats = url,

  SET_FRIENDS_URL: (state, url) => state.urls.friends = url,

  SET_NEW_CHAT_URL: (state, url) => state.urls.newChat = url,

  SET_DELETE_CHAT_URL: (state, url) => state.urls.deleteChat = url,

  SET_NEW_CHATS_AVAILABLE_URL: (state, url) => state.urls.newChatsAvailable = url,

  SET_SEND_MESSAGE_URL: (state, url) => state.urls.sendMessage = url,

  SET_CURRENT_CHAT: (state, chat) => state.currentChat = chat,

  SET_MESSAGES: (state, messages) => state.messsages = messages,
}