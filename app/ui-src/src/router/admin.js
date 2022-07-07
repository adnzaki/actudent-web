import { routeValidator } from '../composables/validate-token'
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
import MonthSummary from 'pages/presence/summary/MonthSummary.vue'
import PeriodSummary from 'pages/presence/summary/PeriodSummary.vue'
import AgendaMain from 'pages/agenda/AgendaMain.vue'
<<<<<<< HEAD
import SiAbsenIndex from 'src/siabsen_pages/Index.vue'
import ManageMain from 'src/siabsen_pages/manage/ManageMain.vue'
import PermitMain from 'src/siabsen_pages/admin_permit/PermitMain.vue'
import AdminSummaryMain from 'src/siabsen_pages/admin_summary/SummaryMain.vue'
import SummaryRoute from 'src/siabsen_pages/admin_summary/SummaryRoute.vue'
import PresenceDetail from 'src/siabsen_pages/admin_summary/PresenceDetail.vue'
import ConfigMain from 'src/siabsen_pages/config/ConfigMain.vue'
=======
import AppSettingsMain from 'pages/app_settings/Index.vue'
>>>>>>> v2-dev

export default [
  { path: '', redirect: 'home' },
  { path: 'home', component: PageIndex,  beforeEnter: () => routeValidator() },
  { path: 'parent', component: ParentMain, beforeEnter: () => routeValidator() },
  { path: 'student', component: StudentMain, beforeEnter: () => routeValidator() },
  { path: 'employee', component: EmployeeMain, beforeEnter: () => routeValidator() },
  { 
    path: 'class', component: ClassMain, beforeEnter: () => routeValidator(),
    children: [
      { path: '', component: ClassList, beforeEnter: () => routeValidator() },
      { path: 'member/:id', component: MemberMain, beforeEnter: () => routeValidator() }
    ]
  },
  { path: 'rooms', component: RoomMain, beforeEnter: () => routeValidator() },
  { path: 'lesson', component: LessonMain, beforeEnter: () => routeValidator() },
  { 
    path: 'schedules', component: ScheduleMain, beforeEnter: () => routeValidator(),
    children: [
      { path: '', component: ClassWrapper, beforeEnter: () => routeValidator() },
      { path: 'lessons/:id', component: LessonsWrapper, beforeEnter: () => routeValidator() },
      { path: 'mapping/:id', component: MappingWrapper, beforeEnter: () => routeValidator() }
    ]
  },
  { 
    path: 'presence', component: PresenceMain, beforeEnter: () => routeValidator(),
    children: [
      { path: '', component: PresenceClassList, beforeEnter: () => routeValidator() },
      { path: 'fill/:id', component: PresenceList, beforeEnter: () => routeValidator() },
      { path: 'monthly-summary/:id', component: MonthSummary, beforeEnter: () => routeValidator() },
      { path: 'period-summary/:id', component: PeriodSummary, beforeEnter: () => routeValidator() },
    ]
  },
  { path: 'agenda', component: AgendaMain, beforeEnter: () => routeValidator() },
  { path: 'app-settings', component: AppSettingsMain, beforeEnter: () => routeValidator() }
]
