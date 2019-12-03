export default {
  getMyChatsUrl: (state) => state.urls.myChats,

  getFriendsUrl: (state) => state.urls.friends,

  getNewChatUrl: (state) => state.urls.newChat,

  getDeleteChatUrl: (state) => state.urls.deleteChat,

  getLeaveChatUrl: (state) => state.urls.leaveChat,

  getNewChatsAvailableUrl: (state) => state.urls.newChatsAvailable,

  getSendMessageUrl: (state) => state.urls.sendMessage,

  getCurrentChat: (state) => state.currentChat,

  getMessages: (state) => state.messages,
}