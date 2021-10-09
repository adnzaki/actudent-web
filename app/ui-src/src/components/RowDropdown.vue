<template>
  <div :class="[rootClass, 'justify-data-options']">
    <q-select outlined v-model="$store.state[vuexModule]['paging']['rows']" 
      :options="options" dense
      @update:model-value="showPerPage"
      :display-value="`${$store.state[vuexModule]['paging']['rows']} ${$t('baris')}`" 
    />
  </div>
</template>

<script>
import { useQuasar } from 'quasar'
import { useStore } from 'vuex'
import { conf, errorNotif } from '../composables/common'

export default {
  name: 'RowDropdown',
  props: {
    rootClass: {
      type: String,
      default: 'col-12 col-md-2 offset-md-2'
    },
    vuexModule: {
      type: String,
      required: true,
    }
  },
  setup(props) {
    const $store = useStore()
    const $q = useQuasar()
    const options = [10, 25, 50, 100, 250]

    return {
      options,
      showPerPage: () => {
        if($q.cookies.has(conf.cookieName)) {
          $store.dispatch(`${props.vuexModule}/showPerPage`)
        } else {
          errorNotif()
        }
      }
    }
  }
}
</script>