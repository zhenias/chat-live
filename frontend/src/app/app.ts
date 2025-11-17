import {Component, inject, signal} from '@angular/core';
import {
  NavigationCancel,
  NavigationEnd,
  NavigationError,
  NavigationStart,
  Router,
  RouterLink,
  RouterOutlet
} from '@angular/router';
import {MatIconButton} from '@angular/material/button';
import {MatToolbar} from '@angular/material/toolbar';
import {MatIconModule} from '@angular/material/icon';
import {AuthService} from '../Core/api/Auth/AuthService';
import {DialogService} from '../Core/service/Dialog/DialogService';
import {MatTooltip} from '@angular/material/tooltip';
import {MatProgressBar} from '@angular/material/progress-bar';
import {LoadingService} from '../Core/service/Loading/LoadingService';
import {AsyncPipe, CommonModule, NgIf} from '@angular/common';

@Component({
  selector: 'app-root',
  imports: [
    RouterOutlet,
    MatIconButton,
    MatToolbar,
    MatIconModule,
    RouterLink,
    MatTooltip,
    MatProgressBar,
    AsyncPipe,
    CommonModule,
    NgIf
  ],
  templateUrl: './app.html',
  styleUrl: './app.css',
  standalone: true,
})
export class App {
  protected readonly title = signal('ChatLive');

  private authService = inject(AuthService);
  private dialogService = inject(DialogService);
  private router = inject(Router);
  private loadingService = inject(LoadingService);

  isLoading$ = this.loadingService.isLoading$;

  constructor() {
    this.router.events.subscribe(event => {
      if (event instanceof NavigationStart) this.loadingService.show();
      if (event instanceof NavigationEnd ||
        event instanceof NavigationCancel ||
        event instanceof NavigationError) this.loadingService.hide();
    });
  }

  public isLogin(): boolean {
    return this.authService.isLoggedIn();
  }

  public logout(): void {
    this.authService.logout();

    this.dialogService.success('Pomyślnie wylogowano.');

    this.router.navigate(['/']);
  }
}
