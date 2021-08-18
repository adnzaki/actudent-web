import { validateToken } from '../composables/validate-token'
import { triggerMode } from '../composables/mode'
import PageIndex from 'pages/home/Index.vue'
import ParentMain from 'pages/parent/ParentMain.vue'
import StudentMain from 'pages/student/StudentMain.vue'
import EmployeeMain from 'pages/employee/EmployeeMain.vue'
import ClassMain from 'pages/class/ClassMain.vue'
import ClassList from 'pages/class/ClassList.vue'
import MemberMain from 'pages/class/MemberMain.vue'

const admin = {
  path: '/',
  component: () => import('layouts/MainLayout.vue'),
  children: [
    { path: '', beforeEnter: () => validateToken('is_admin'), redirect: 'home' },
    { path: 'home', component: PageIndex, beforeEnter: () => validateToken('is_admin') },
    { path: 'parent', component: ParentMain, beforeEnter: () => validateToken('is_admin') },
    { path: 'student', component: StudentMain, beforeEnter: () => validateToken('is_admin') },
    { path: 'employee', component: EmployeeMain, beforeEnter: () => validateToken('is_admin') },
    { 
      path: 'class', component: ClassMain, beforeEnter: () => validateToken('is_admin'),
      children: [
        { path: '', component: ClassList, beforeEnter: () => validateToken('is_admin') },
        { path: 'member/:id', component: MemberMain, beforeEnter: () => validateToken('is_admin') }
      ]
    },
  ],
  beforeEnter: () => {
    validateToken('is_admin')   
    triggerMode()   
  }
}

export default admin
