import { inject, Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import {firstValueFrom} from 'rxjs';
import ChatTypes from './Chat.types';
import ConfigService from '../../service/Config/ConfigService';


@Injectable({ providedIn: 'root' })
export class Chat {
  private http = inject(HttpClient);
  private config = new ConfigService();

  private endpoint = "chats";

  async getChats(): Promise<ChatTypes> {
    try {
      const response = await firstValueFrom(this.http.get<ChatTypes>(
        this.config.url + '/api/' + this.endpoint
      ));

      return response;
    } catch (e) {

      throw e;
    }
  }
}
