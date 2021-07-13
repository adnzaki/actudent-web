import { validateToken } from '../composables/validate-token'
import { triggerMode } from '../composables/mode'
import PageIndex from 'pages/home/Index.vue'
import ParentMain from 'pages/parent/ParentMain.vue'
import StudentMain from 'pages/student/StudentMain.vue'
import EmployeeMain from 'pages/employee/EmployeeMain.vue'

const admin = {
  path: '/',
  component: () => import('layouts/MainLayout.vue'),
  children: [
    { path: '', component: PageIndex, beforeEnter: () => validateToken('is_admin') },
    { path: 'home', component: PageIndex, beforeEnter: () => validateToken('is_admin') },
    { path: 'parent', component: ParentMain, beforeEnter: () => validateToken('is_admin') },
    { path: 'student', component: StudentMain, beforeEnter: () => validateToken('is_admin') },
    { path: 'employee', component: EmployeeMain, beforeEnter: () => validateToken('is_admin') }
  ],
  beforeEnter: () => {
    validateToken('is_admin')   
    triggerMode()   
  }
}

export default admin
