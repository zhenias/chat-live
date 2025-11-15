import {Component, inject, signal} from '@angular/core';
import {Router, RouterLink, RouterOutlet} from '@angular/router';
import {MatIconButton} from '@angular/material/button';
import {MatToolbar} from '@angular/material/toolbar';
import {MatIconModule} from '@angular/material/icon';
import {AuthService} from '../Core/api/Auth/AuthService';
import {DialogService} from '../Core/service/Dialog/DialogService';
import {MatTooltip} from '@angular/material/tooltip';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet, MatIconButton, MatToolbar, MatIconModule, RouterLink, MatTooltip],
  templateUrl: './app.html',
  styleUrl: './app.css',
  standalone: true,
})
export class App {
  protected readonly title = signal('ChatLive');

  private authService = inject(AuthService);
  private dialogService = inject(DialogService);
  private router = inject(Router);

  public isLogin(): boolean {
    return this.authService.isLoggedIn();
  }

  public logout(): void {
    this.authService.logout();

    this.dialogService.success('Pomyślnie wylogowano.');

    this.router.navigate(['/']);
  }
}
