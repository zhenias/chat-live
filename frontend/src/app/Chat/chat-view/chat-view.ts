import {Component, inject} from '@angular/core';
import {Chat} from '../../../Core/api/Chat/Chat';
import ChatTypes from '../../../Core/api/Chat/Chat.types';

@Component({
  selector: 'app-chat-view',
  imports: [],
  templateUrl: './chat-view.html',
})
export class ChatView {
  private chatApi = new Chat();
  public chatsResponse: ChatTypes | undefined;

  constructor() {
    this.get();
  }

  private async get() {
    try {
      const response = this.chatApi.getChats();

      this.chatsResponse = await response;
    } catch (e) {
      console.log('error', e);
    }
  }
}
