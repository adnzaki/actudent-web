import validateToken from '../composables/validate-token'

const routes = [
  {
    path: '/',
    component: () => import('layouts/AdminLayout.vue'),
    children: [
      { path: '', component: () => import('pages/home/Index.vue') },
      { path: 'home', component: () => import('pages/Home.vue') }
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
