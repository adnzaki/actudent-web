import { routeValidator } from 'src/composables/validate-token'
import TeacherIndex from 'src/pages_teacher/home/TeacherIndex.vue'
import PresenceMain from 'src/pages_teacher/presence/PresenceMain.vue'
import ScheduleList from 'src/pages_teacher/presence/ScheduleList.vue'
import PresenceList from 'pages/presence/PresenceList.vue'

export default [
  { 
    path: 'teacher', component: TeacherIndex, beforeEnter: () => routeValidator('is_teacher'), children: [
      { path: 'home', component: TeacherIndex,  beforeEnter: () => routeValidator('is_teacher') },
    ],    
  },
  {
    path: 'teacher/presence', component: PresenceMain, beforeEnter: () => routeValidator('is_teacher'),
    children: [
      { path: '', component: ScheduleList, beforeEnter: () => routeValidator('is_teacher') },
      { path: 'fill/:scheduleId/:classId/:activeDate', component: PresenceList, beforeEnter: () => routeValidator('is_teacher') },
    ]
  }
]
