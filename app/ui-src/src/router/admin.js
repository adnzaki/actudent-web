import { validateToken } from '../composables/validate-token'
import { triggerMode } from '../composables/mode'
import PageIndex from 'pages/home/Index.vue'
import ParentMain from 'pages/parent/ParentMain.vue'
import StudentMain from 'pages/student/StudentMain.vue'
import EmployeeMain from 'pages/employee/EmployeeMain.vue'
import ClassMain from 'pages/class/ClassMain.vue'
import ClassList from 'pages/class/ClassList.vue'
import MemberMain from 'pages/class/MemberMain.vue'
import RoomMain from 'pages/rooms/RoomMain.vue'
import LessonMain from 'pages/lesson/LessonMain.vue'
import ScheduleMain from 'pages/schedules/ScheduleMain.vue'
import ClassWrapper from 'pages/schedules/ClassWrapper.vue'
import LessonsWrapper from 'pages/schedules/LessonsWrapper.vue'

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
    { path: 'rooms', component: RoomMain, beforeEnter: () => validateToken('is_admin') },
    { path: 'lesson', component: LessonMain, beforeEnter: () => validateToken('is_admin') },
    { 
      path: 'schedules', component: ScheduleMain, beforeEnter: () => validateToken('is_admin'),
      children: [
        { path: '', component: ClassWrapper, beforeEnter: () => validateToken('is_admin') },
        { path: 'lessons/:id', component: LessonsWrapper, beforeEnter: () => validateToken('is_admin') },
        { path: 'mapping/:id', component: '', beforeEnter: () => validateToken('is_admin') }
      ]
    },
  ],
  beforeEnter: () => {
    validateToken('is_admin')   
    triggerMode()   
  }
}

export default admin
