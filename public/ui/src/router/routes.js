import { validateToken } from '../composables/validate-token'
import { triggerMode } from '../composables/mode-comp'

const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import('pages/home/Index.vue') },
      { path: 'home', component: () => import('pages/home/Index.vue') },
      { path: 'parent', component: () => import('pages/parent/ParentMain.vue') }
    ],
    beforeEnter: () => {
      validateToken('is_admin')   
      triggerMode()   
    }
  },
  {
    path: '/guru',
    component: () => import('layouts/MainLayout.vue'),
    children: [
    ],
    beforeEnter: () => {
      validateToken('is_teacher')
    }
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/Error404.vue')
  }
]

export default routes
