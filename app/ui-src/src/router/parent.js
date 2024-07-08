import { routeValidator } from 'src/composables/validate-token'
import AppSettingsMain from 'src/pages/app_settings/IndexPage.vue'

// prettier-ignore
export default [
  {
    path: 'parent',
    component: () => import('src/pages_parent/home/ParentIndex.vue'),
    beforeEnter: () => routeValidator('valid_token'),
    children: [
      {
        path: 'home',
        component: () => import('src/pages_parent/home/ParentIndex.vue'),
        beforeEnter: () => routeValidator('valid_token'),
      },
    ],
  },
  { path: 'parent/app-settings', component: AppSettingsMain, beforeEnter: () => routeValidator('valid_token') }
]
