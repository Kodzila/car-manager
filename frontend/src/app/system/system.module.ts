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

export const COMPONENTS = [
    ContainerPage,
    FrontPage,
    Toolbar,
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
    ],
    providers: [],
})
export class SystemModule { }
