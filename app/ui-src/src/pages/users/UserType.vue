<template>
  <div class="col-12 col-md-3 offset-md-3 q-mt-sm">
    <q-select
      outlined
      v-model="model"
      :options="options"
      dense
      @update:model-value="getUserByType"
    />
  </div>
</template>

<script>
import { ref } from 'vue'
import { useStore } from 'vuex'
import { t } from 'src/composables/common'

export default {
  setup() {
    const options = ref([])
    const model = ref({})
    const store = useStore()
    
    setTimeout(() => {
      options.value = [
        { label: t('user_semua_bagian'), value: 'null' },
        { label: t('pengguna_guru'), value: 2 },
        { label: 'Staff', value: 0 },
        { label: t('pengguna_ortu'), value: 3 }
      ]

      model.value = { 
        label: t('user_semua_bagian'), value: 'null' 
      }
      
    }, 1500);

    const getUsers = () => {
      store.dispatch('users/getUsers')
    }

    getUsers()
    
    return {
      getUserByType: model => store.dispatch('users/getUserByType', model),
      options,
      model,
    }
  } 
}
</script>