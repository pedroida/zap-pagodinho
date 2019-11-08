export default {
  SET_FRIENDS_URL: (state, url) => state.urls.friends = url,

  SET_NEW_CHAT_URL: (state, url) => state.urls.newChat = url,

  SET_NEW_CHATS_AVAILABLE_URL: (state, url) => state.urls.newChatsAvailable = url,
}