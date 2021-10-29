import { store } from 'quasar/wrappers'
import { createStore } from 'vuex'
import parent from './parent'
import student from './student'
import employee from './employee'
import grade from './grade'
import rooms from './rooms'
import lesson from './lesson'
import schedule from './schedule'

/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Store instance.
 */

export default store(function (/* { ssrContext } */) {
  const Store = createStore({
    modules: {
      parent, student, employee, grade,
      rooms, lesson, schedule
    },

    // enable strict mode (adds overhead!)
    // for dev mode and --debug builds only
    strict: false
  })

  return Store
})
