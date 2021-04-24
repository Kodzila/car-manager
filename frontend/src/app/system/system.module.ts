import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {ContainerPage} from "./container-page/container-page";
import {FrontPage} from "./front-page/front-page";
import {RouterModule} from "@angular/router";
import {Toolbar} from './toolbar/toolbar';
import {MatToolbarModule} from "@angular/material/toolbar";
import {MatIconModule} from "@angular/material/icon";
import {MatButtonModule} from "@angular/material/button";
import {MatCardModule} from "@angular/material/card";
import {LoginPage} from "./login-page/login-page";
import {MatFormFieldModule} from "@angular/material/form-field";
import {MatInputModule} from "@angular/material/input";
import {ReactiveFormsModule} from "@angular/forms";

export const COMPONENTS = [
    ContainerPage,
    FrontPage,
    Toolbar,
    LoginPage,
];

export const EXPORTED_COMPONENTS = [];

@NgModule({
    declarations: [COMPONENTS, EXPORTED_COMPONENTS],
    exports: [EXPORTED_COMPONENTS],
    imports: [
        CommonModule,
        RouterModule,
        MatToolbarModule,
        MatIconModule,
        MatButtonModule,
        MatCardModule,
        MatFormFieldModule,
        MatInputModule,
        ReactiveFormsModule,
    ],
    providers: [],
})
export class SystemModule { }
