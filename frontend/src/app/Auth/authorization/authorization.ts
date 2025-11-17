import {Component, inject} from '@angular/core';
import {FormBuilder, FormsModule, ReactiveFormsModule, Validators} from '@angular/forms';
import {MatCard} from '@angular/material/card';
import {MatFormFieldModule} from '@angular/material/form-field';
import {MatInput} from '@angular/material/input';
import {MatButton} from '@angular/material/button';
import {AuthService} from '../../../Core/api/Auth/AuthService';
import {Router} from '@angular/router';
import {DialogService} from '../../../Core/service/Dialog/DialogService';
import {LoadingService} from '../../../Core/service/Loading/LoadingService';

@Component({
  selector: 'app-authorization',
  templateUrl: './authorization.html',
  styleUrls: ['./authorization.css'],
  imports: [
    MatCard,
    MatFormFieldModule,
    FormsModule,
    MatInput,
    MatButton,
    ReactiveFormsModule
  ],
})
export class Authorization {
  private fb = inject(FormBuilder);
  private auth = inject(AuthService);
  private dialog = inject(DialogService);
  private router = inject(Router);
  private loadingService = inject(LoadingService);

  form = this.fb.group({
    email: ['ddd@example.com', [Validators.required, Validators.email]],
    password: ['passwd', Validators.required]
  });

  submit(): void {
    if (this.form.valid) {
      this.getAuth();
    }
  }

  private async getAuth(): Promise<void> {
    this.loadingService.show();

    try {
      await this.auth.login(
        this.form.value.email,
        this.form.value.password
      );

      await this.router.navigate(['/chats']);
    } catch (e) {
      this.dialog.error('Wystąpił błąd, podczas logowania..');
    } finally {
      this.loadingService.hide();
    }
  }
}
