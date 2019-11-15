export default {
  getMyChatsUrl: (state) => state.urls.myChats,

  getFriendsUrl: (state) => state.urls.friends,

  getNewChatUrl: (state) => state.urls.newChat,

  getNewChatsAvailableUrl: (state) => state.urls.newChatsAvailable,

  getCurrentChat: (state) => state.currentChat,
}