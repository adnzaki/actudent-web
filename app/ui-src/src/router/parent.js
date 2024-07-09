import { routeValidator } from 'src/composables/validate-token'
import AppSettingsMain from 'src/pages/app_settings/IndexPage.vue'
import AgendaMain from 'pages/agenda/AgendaMain.vue'
import PresenceMain from 'src/pages_student/presence/PresenceMain.vue'

// prettier-ignore
export default [
  {
    path: 'student',
    component: () => import('src/pages_student/home/StudentIndex.vue'),
    beforeEnter: () => routeValidator('valid_token'),
    children: [
      {
        path: 'home',
        component: () => import('src/pages_student/home/StudentIndex.vue'),
        beforeEnter: () => routeValidator('valid_token'),
      },
    ],
  },
  { path: 'student/presence', component: PresenceMain, beforeEnter: () => routeValidator('is_parent') },
  { path: 'student/agenda', component: AgendaMain, beforeEnter: () => routeValidator('valid_token') },
  { path: 'student/app-settings', component: AppSettingsMain, beforeEnter: () => routeValidator('valid_token') }
]
