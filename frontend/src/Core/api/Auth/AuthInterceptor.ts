import { inject, Injectable } from '@angular/core';
import {
  HttpInterceptor,
  HttpRequest,
  HttpHandler,
  HttpEvent,
} from '@angular/common/http';
import { Observable, from, throwError } from 'rxjs';
import { TokenService } from './TokenService';
import { AuthService } from './AuthService';
import { catchError, switchMap } from 'rxjs/operators';

@Injectable()
export class AuthInterceptor implements HttpInterceptor {
  private tokenService = inject(TokenService);
  private authService = inject(AuthService);

  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    const token = this.tokenService.getAccessToken();

    let newReq = req;
    if (token) {
      newReq = req.clone({
        setHeaders: { Authorization: `Bearer ${token}` },
      });
    }

    return next.handle(newReq).pipe(
      catchError(err => {
        if (err.status === 401 && this.tokenService.getRefreshToken()) {
          return from(this.authService.refresh()).pipe(
            switchMap(() => {
              const newToken = this.tokenService.getAccessToken();
              const retriedReq = req.clone({
                setHeaders: { Authorization: `Bearer ${newToken}` },
              });
              return next.handle(retriedReq);
            })
          );
        }
        return throwError(() => err);
      })
    );
  }
}
