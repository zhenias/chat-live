import {Component, inject} from '@angular/core';
import {FormBuilder, FormsModule, ReactiveFormsModule, Validators} from '@angular/forms';
import {MatCard} from '@angular/material/card';
import {MatFormFieldModule} from '@angular/material/form-field';
import {MatInput} from '@angular/material/input';
import {MatButton} from '@angular/material/button';
import {AuthService} from '../../../Core/api/Auth/AuthService';
import {DialogService} from '../../../Service/Dialog/DialogService';
import {Router} from '@angular/router';

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
  private fb = new FormBuilder();
  private auth = new AuthService();
  private dialog = inject(DialogService);
  private router = inject(Router);

  form = this.fb.group({
    email: ['ddd@example.com', [Validators.required, Validators.email]],
    password: ['passwd', Validators.required]
  });

  submit() {
    if (this.form.valid) {
      console.log('Form:', this.form.value);

      this.getAuth();
    }
  }

  async getAuth() {
    try {
      const response = await this.auth.login(
        this.form.value.email,
        this.form.value.password
      );

      this.dialog.success('Zalogowano pomyślnie.');

      this.router.navigate(['/']);
    } catch (e) {
      console.log('Error:', e);

      this.dialog.error('Wystąpił błąd, podczas logowania..');
    }
  }
}
