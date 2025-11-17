import {inject, Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {firstValueFrom} from 'rxjs';
import ChatTypesResponse, {ChatMessageResponse} from './Chat.types';
import {ConfigService} from '../../service/Config/ConfigService';
import {LoadingService} from '../../service/Loading/LoadingService';


@Injectable({
  providedIn: 'root'
})
export default class Chat {
  private endpoint = "/chats";

  private http = inject(HttpClient);
  private config = new ConfigService();

  async getChats(): Promise<ChatTypesResponse> {
    try {
      return await firstValueFrom(this.http.get<ChatTypesResponse>(
        this.config.apiUrl + this.endpoint
      ));
    } catch (e) {
      throw e;
    }
  }

  async getMessages(chatId: number): Promise<ChatMessageResponse> {
    try {
      return await firstValueFrom(this.http.get<ChatMessageResponse>(
        this.config.apiUrl + this.endpoint + `/${chatId}/messages`
      ));
    } catch (e) {
      throw e;
    }
  }
}
