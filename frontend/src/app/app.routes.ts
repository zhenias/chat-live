import { Routes } from '@angular/router';
import {Authorization} from './Auth/authorization/authorization';
import {Baner} from './Auth/baner/baner';
import {ChatView} from './Chat/chat-view/chat-view';
import {AuthGuard} from '../Core/guard/Auth/AuthGuard';
import {NotFound} from './Error/not-found/not-found';

export const routes: Routes = [
  { path: '', component: Baner },
  { path: 'login', component: Authorization },
  { path: 'chats', component: ChatView, canActivate: [AuthGuard] },

  // tu powinno być!
  { path: '**', component: NotFound },
];
