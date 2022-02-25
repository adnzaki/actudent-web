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
  { path: '/login', component: () => import('layouts/Login.vue') },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/Error404.vue')
  }
]

export default routes
