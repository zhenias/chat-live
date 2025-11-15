import { inject, Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { firstValueFrom } from 'rxjs';
import { TokenService } from './TokenService';
import ConfigService from '../../service/Config/ConfigService';

interface LoginWithPasswordResponse {
  token_type: string;
  expires_in: number;
  access_token: string;
  refresh_token: string;
}

@Injectable({ providedIn: 'root' })
export class AuthService {
  private http = inject(HttpClient);
  private config = new ConfigService();
  private tokenService = inject(TokenService);

  async login(email: string | undefined | null, password: string | undefined | null): Promise<void> {
    const url = `${this.config.url}/oauth/token`;

    const payload = {
      grant_type: 'password',
      client_id: this.config.clientId,
      client_secret: this.config.clientSecret,
      username: email,
      password,
      scope: '',
    };

    try {
      const response = await firstValueFrom(
        this.http.post<LoginWithPasswordResponse>(url, payload)
      );

      this.tokenService.saveTokens(response);
    } catch (error) {
      console.error('Błąd logowania:', error);
      throw error;
    }
  }

  async refresh(): Promise<void> {
    const refreshToken = this.tokenService.getRefreshToken();
    if (!refreshToken) throw new Error('Brak refresh_token');

    const url = `${this.config.url}/oauth/token`;
    const payload = {
      grant_type: 'refresh_token',
      refresh_token: refreshToken,
      client_id: this.config.clientId,
      client_secret: this.config.clientSecret,
    };

    try {
      const response = await firstValueFrom(
        this.http.post<LoginWithPasswordResponse>(url, payload)
      );
      this.tokenService.saveTokens(response);
    } catch (error) {
      console.error('Błąd odświeżenia tokena:', error);
      this.tokenService.clear();
      throw error;
    }
  }

  isLoggedIn(): boolean {
    const token = this.tokenService.getAccessToken();

    return !!token && !this.tokenService.isTokenExpired();
  }

  logout(): void {
    this.tokenService.clear();
  }
}
