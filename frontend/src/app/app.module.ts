import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import {RouterModule, Routes} from "@angular/router";
import { ContainerPage } from './system/container-page/container-page';
import { FrontPage } from './system/front-page/front-page';
import {SystemModule} from "./system/system.module";
import {AppComponent} from "./app";

const APP_ROUTES: Routes = [
    {
        path: '',
        pathMatch: 'prefix',
        component: ContainerPage,
        children: [
            {
                path: '',
                pathMatch: 'full',
                component: FrontPage,
            },
        ],
    },
];

@NgModule({
  declarations: [AppComponent],
  imports: [
      BrowserModule,
      RouterModule.forRoot(APP_ROUTES, {
          onSameUrlNavigation: 'ignore',
          anchorScrolling: 'enabled',
          relativeLinkResolution: 'corrected',
          scrollPositionRestoration: 'top',
          initialNavigation: 'enabled',
      }),
      BrowserAnimationsModule,
      SystemModule,
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
