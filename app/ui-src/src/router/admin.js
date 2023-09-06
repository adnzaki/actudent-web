import { routeValidator } from '../composables/validate-token'
import UserAccount from 'src/pages/account/IndexPage.vue'
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
import SiAbsenIndex from 'src/siabsen_pages/IndexPage.vue'
import ManageMain from 'src/siabsen_pages/manage/ManageMain.vue'
import PermitMain from 'src/siabsen_pages/admin_permit/PermitMain.vue'
import AdminSummaryMain from 'src/siabsen_pages/admin_summary/SummaryMain.vue'
import SummaryRoute from 'src/siabsen_pages/admin_summary/SummaryRoute.vue'
import PresenceDetail from 'src/siabsen_pages/admin_summary/PresenceDetail.vue'
import ConfigMain from 'src/siabsen_pages/config/ConfigMain.vue'
import AppSettingsMain from 'pages/app_settings/IndexPage.vue'
import PresenceScheduleMain from 'src/siabsen_pages/presence_schedule/ScheduleMain.vue'
import AdminEvents from 'src/siabsen_pages/admin_events/EventsMain.vue'
import EventsRoute from 'src/siabsen_pages/admin_events/EventsRoute.vue'
import EventsAttendance from 'src/siabsen_pages/admin_events/EventsAttendance.vue'
import Holiday from 'src/siabsen_pages/holiday/MainPage.vue'
import UsersMain from 'pages/users/UsersMain.vue'
import PostMain from 'pages/post/PostMain.vue'
import ViewPostMobile from 'pages/post/ViewPostMobile.vue'
import ReportSettings from 'pages/report_settings/IndexPage.vue'

export default [
  { path: '', redirect: 'home' },
  { path: 'home', component: PageIndex, beforeEnter: () => routeValidator() },
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
  { path: 'account', component: UserAccount, beforeEnter: () => routeValidator('valid_token') },

  { path: 'agenda', component: AgendaMain, beforeEnter: () => routeValidator() },
  { path: 'app-settings', component: AppSettingsMain, beforeEnter: () => routeValidator() },

  // ----------------------------------------------------------------------------------------------------
  // ------------------------------------------ SIABSEN ROUTES ------------------------------------------
  // ----------------------------------------------------------------------------------------------------

  {
    path: 'teacher-presence', component: SiAbsenIndex, beforeEnter: () => routeValidator(),
    children: [
      { path: '', component: ManageMain, beforeEnter: () => routeValidator() },
      {
        path: 'events', component: EventsRoute, beforeEnter: () => routeValidator(),
        children: [
          { path: '', component: AdminEvents, beforeEnter: () => routeValidator() },
          { path: 'attendance/:agendaId', component: EventsAttendance, beforeEnter: () => routeValidator() }
        ]
      },
      { path: 'manage', component: ManageMain, beforeEnter: () => routeValidator() },
      { path: 'permit', component: PermitMain, beforeEnter: () => routeValidator() },
      {
        path: 'monthly-summary', component: SummaryRoute, beforeEnter: () => routeValidator(),
        children: [
          { path: '', component: AdminSummaryMain, beforeEnter: () => routeValidator() },
          { path: 'detail/:staffId/:userId/:dateStart/:dateEnd', component: PresenceDetail, beforeEnter: () => routeValidator() },
        ]
      },
      { path: 'config', component: ConfigMain, beforeEnter: () => routeValidator() },
      { path: 'schedule', component: PresenceScheduleMain, beforeEnter: () => routeValidator() },
      { path: 'holiday', component: Holiday, beforeEnter: () => routeValidator() },
    ]
  },
  { path: 'users', component: UsersMain, beforeEnter: () => routeValidator() },
  { path: 'post', component: PostMain, beforeEnter: () => routeValidator('valid_token') },
  { path: 'post/view/:id', component: ViewPostMobile, beforeEnter: () => routeValidator('valid_token') },
  { path: 'report-settings', component: ReportSettings, beforeEnter: () => routeValidator() }
]
