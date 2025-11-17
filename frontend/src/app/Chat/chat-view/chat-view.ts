import {Component, inject} from '@angular/core';
import Chat from '../../../Core/api/Chat/Chat';
import {NgForOf, NgIf, UpperCasePipe} from '@angular/common';

import { MatListModule } from '@angular/material/list';
import { MatIconModule } from '@angular/material/icon';
import {MatDividerModule} from '@angular/material/divider';
import ChatTypesResponse, {ChatMessageResponse, ChatMessageTypes} from '../../../Core/api/Chat/Chat.types';
import {LoadingService} from '../../../Core/service/Loading/LoadingService';
import ChatTypes from '../../../Core/api/Chat/Chat.types';

@Component({
  selector: 'app-chat-view',
  imports: [
    NgForOf,
    UpperCasePipe,
    MatIconModule,
    MatListModule,
    MatDividerModule,
    NgIf,
  ],
  templateUrl: './chat-view.html',
})
export class ChatView {
  private chatApi = new Chat();
  public chatsResponse: ChatTypesResponse[] | undefined;
  private loadingService = inject(LoadingService);

  constructor() {
    this.get();
  }

  private async get() {
    this.loadingService.show();

    try {
      const response = await this.chatApi.getChats();

      this.chatsResponse = response.data;
    } catch (e) {
      console.log('error', e);
    } finally {
      this.loadingService.hide();
    }
  }

  protected selectedChat: ChatTypes | undefined;
  public messages: ChatMessageTypes[] | undefined;

  selectChat(chat: ChatTypes) {
    this.loadingService.show();

    this.selectedChat = chat;

    // Wywołujesz API np.
    this.chatApi.getMessages(chat.id).then(res => {
      this.messages = res.data;

      this.loadingService.hide();
    });
  }
}
