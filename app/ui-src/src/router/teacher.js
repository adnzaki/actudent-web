import { validateToken } from '../composables/validate-token'
import { triggerMode } from '../composables/mode'

const teacher = {
  path: '/guru',
  component: () => import('layouts/MainLayout.vue'),
  children: [
  ],
  beforeEnter: () => {
    validateToken('is_teacher')
  }
}

export default teacher