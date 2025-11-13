import { inject, Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import ConfigService from '../../../Service/Config/ConfigService';
import {TokenService} from '../Auth/TokenService';
import {firstValueFrom} from 'rxjs';
import ChatTypes from './Chat.types';


@Injectable({ providedIn: 'root' })
export class Chat {
  private http = inject(HttpClient);
  private config = new ConfigService();
  private tokenService = inject(TokenService);

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
