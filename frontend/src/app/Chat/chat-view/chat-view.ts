import {Component} from '@angular/core';
import {Chat} from '../../../Core/api/Chat/Chat';
import ChatResponse from '../../../Core/api/Chat/Chat.types';
import {NgForOf, NgIf, UpperCasePipe} from '@angular/common';

import { MatListModule } from '@angular/material/list';
import { MatIconModule } from '@angular/material/icon';
import {MatDividerModule} from '@angular/material/divider';

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
  public chatsResponse: ChatResponse[] | undefined;

  constructor() {
    this.get();
  }

  private async get() {
    try {
      const response = await this.chatApi.getChats();

      this.chatsResponse = response.data;
    } catch (e) {
      console.log('error', e);
    }
  }

  selectedChat: any = null;
  messages: any[] = [];

  selectChat(chat: any) {
    this.selectedChat = chat;

    // Wywołujesz API np.
    // this.api.getMessages(chat.id).subscribe(res => {
    //   this.messages = res;
    // });
  }
}
