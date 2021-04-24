import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {ContainerPage} from "./container-page/container-page";
import {FrontPage} from "./front-page/front-page";
import {RouterModule} from "@angular/router";

export const COMPONENTS = [
    ContainerPage,
    FrontPage,
];

export const EXPORTED_COMPONENTS = [];

@NgModule({
    declarations: [COMPONENTS, EXPORTED_COMPONENTS],
    exports: [EXPORTED_COMPONENTS],
    imports: [
        CommonModule,
        RouterModule,
    ],
    providers: [],
})
export class SystemModule { }
