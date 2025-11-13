import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import {AuthService} from '../../Core/api/Auth/AuthService';
import {DialogService} from '../../Service/Dialog/DialogService';

export const authGuard: CanActivateFn = () => {
  const auth = inject(AuthService);
  const router = inject(Router);
  const dialogService = inject(DialogService);

  if (auth.isLoggedIn()) {
    return true;
  }

  dialogService.error('Musisz być zalogowany, by zobaczyć tą część witryny.');

  router.navigate(['/login']);
  return false;
};
