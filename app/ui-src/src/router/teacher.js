import { routeValidator } from '../composables/validate-token'
import TeacherIndex from 'pages/t_home/TeacherIndex.vue'

export default [
  { 
    path: 'teacher', component: TeacherIndex, beforeEnter: () => routeValidator('is_teacher'), children: [
      { path: 'home', component: TeacherIndex,  beforeEnter: () => routeValidator('is_teacher') },
    ]
  }  
]
