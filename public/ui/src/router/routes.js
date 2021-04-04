import { validateToken } from '../composables/validate-token'

const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import('pages/home/Index.vue') }
    ],
    beforeEnter: () => {
      validateToken('is_admin')
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
