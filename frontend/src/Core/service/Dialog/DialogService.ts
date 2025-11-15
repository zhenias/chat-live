import { Injectable } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { MatSnackBar } from '@angular/material/snack-bar';
import {ConfirmDialogComponent} from '../../../app/Dialog/ConfigmDialog/ConfirmDialogComponent';

@Injectable({ providedIn: 'root' })
export class DialogService {
  constructor(private snackBar: MatSnackBar, private dialog: MatDialog) {}

  success(message: string): void {
    this.snackBar.open(message, 'OK', {
      duration: 3000,
      panelClass: ['success-snackbar']
    });
  }

  error(message: string): void {
    this.snackBar.open(message, 'Zamknij', {
      duration: 4000,
      panelClass: ['error-snackbar']
    });
  }

  confirm(message: string): Promise<boolean> {
    return new Promise(resolve => {
      const dialogRef = this.dialog.open(ConfirmDialogComponent, {
        data: { message },
      });
      dialogRef.afterClosed().subscribe(result => resolve(result === true));
    });
  }
}
