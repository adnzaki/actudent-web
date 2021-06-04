import admin from './admin'
import teacher from './teacher'

const routes = [
  admin,
  teacher,

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/Error404.vue')
  }
]

export default routes
