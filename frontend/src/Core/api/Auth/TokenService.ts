import { Injectable } from '@angular/core';

@Injectable({ providedIn: 'root' })
export class TokenService {
  private accessKey = 'access_token';
  private refreshKey = 'refresh_token';
  private expiresKey = 'token_expires_at';

  saveTokens(data: { access_token: string; refresh_token: string; expires_in: number }): void {
    const expiresAt = Date.now() + data.expires_in * 1000;
    localStorage.setItem(this.accessKey, data.access_token);
    localStorage.setItem(this.refreshKey, data.refresh_token);
    localStorage.setItem(this.expiresKey, expiresAt.toString());
  }

  getAccessToken(): string | null {
    return localStorage.getItem(this.accessKey);
  }

  getRefreshToken(): string | null {
    return localStorage.getItem(this.refreshKey);
  }

  isTokenExpired(): boolean {
    const exp = Number(localStorage.getItem(this.expiresKey));
    return !exp || Date.now() > exp;
  }

  clear(): void {
    localStorage.removeItem(this.accessKey);
    localStorage.removeItem(this.refreshKey);
    localStorage.removeItem(this.expiresKey);
  }
}
