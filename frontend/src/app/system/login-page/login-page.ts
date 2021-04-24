import {ChangeDetectionStrategy, ChangeDetectorRef, Component, OnInit} from '@angular/core';
import {FormBuilder} from "@angular/forms";

@Component({
    selector: 'app-login-page',
    templateUrl: './login-page.html',
    styleUrls: ['./login-page.sass'],
    changeDetection: ChangeDetectionStrategy.OnPush,
})
export class LoginPage implements OnInit {
    formGroup = this.fb.group({
        email: [''],
        password: [''],
    });

    constructor(
        private fb: FormBuilder,
        private cdRef: ChangeDetectorRef,
    ) {}

    onSubmit() {
        const { email, password } = this.formGroup.value;
    }

    ngOnInit(): void {
    }
}
