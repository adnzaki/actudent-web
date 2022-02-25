import { validateToken } from '../composables/validate-token'
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
import MappingWrapper from 'pages/schedules/MappingWrapper.vue'
import PresenceMain from 'pages/presence/PresenceMain.vue'
import PresenceClassList from 'pages/presence/PresenceClassList.vue'
import PresenceList from 'pages/presence/PresenceList.vue'
import checkSubscription from 'src/composables/subscription'

const admin = [
  { path: '', redirect: 'home' },
  { path: 'home', component: PageIndex,  beforeEnter: validatePage },
  { path: 'parent', component: ParentMain, beforeEnter: validatePage },
  { path: 'student', component: StudentMain, beforeEnter: validatePage },
  { path: 'employee', component: EmployeeMain, beforeEnter: validatePage },
  { 
    path: 'class', component: ClassMain, beforeEnter: validatePage,
    children: [
      { path: '', component: ClassList, beforeEnter: validatePage },
      { path: 'member/:id', component: MemberMain, beforeEnter: validatePage }
    ]
  },
  { path: 'rooms', component: RoomMain, beforeEnter: validatePage },
  { path: 'lesson', component: LessonMain, beforeEnter: validatePage },
  { 
    path: 'schedules', component: ScheduleMain, beforeEnter: validatePage,
    children: [
      { path: '', component: ClassWrapper, beforeEnter: validatePage },
      { path: 'lessons/:id', component: LessonsWrapper, beforeEnter: validatePage },
      { path: 'mapping/:id', component: MappingWrapper, beforeEnter: validatePage }
    ]
  },
  { 
    path: 'presence', component: PresenceMain, beforeEnter: validatePage,
    children: [
      { path: '', component: PresenceClassList, beforeEnter: validatePage },
      { path: 'fill/:id', component: PresenceList, beforeEnter: validatePage }
    ]
  },
]

function validatePage() {
  checkSubscription()
  validateToken('is_admin')
}

export default admin
