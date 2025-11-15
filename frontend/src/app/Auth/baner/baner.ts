import { Component } from '@angular/core';
import {RouterLink} from '@angular/router';
import {MatButton} from '@angular/material/button';

@Component({
  selector: 'app-baner',
  imports: [
    RouterLink,
    MatButton
  ],
  templateUrl: './baner.html',
  styleUrl: './baner.css',
})
export class Baner {

}
