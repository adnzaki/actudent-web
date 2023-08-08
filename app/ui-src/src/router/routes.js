import admin from './admin'
import teacher from './teacher'
import { triggerMode } from '../composables/mode'

const routes = [
  {
    path: '/',
    component: () => import('src/layouts/MainLayout.vue'),
    children: admin.concat(teacher),
    beforeEnter: () => triggerMode()
  },
  { path: '/login', component: () => import('src/layouts/Login.vue') },
  { path: '/setup', component: () => import('src/layouts/SetupPage.vue') },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
