import { Routes } from '@angular/router';
import {App} from './app';
import {Authorization} from './Auth/authorization/authorization';
import {Baner} from './Auth/baner/baner';
import {ChatView} from './Chat/chat-view/chat-view';
import {AuthGuard} from '../Core/guard/Auth/AuthGuard';

export const routes: Routes = [
  { path: '', component: Baner },
  { path: 'login', component: Authorization },
  { path: 'chats', component: ChatView, canActivate: [AuthGuard] }
];
