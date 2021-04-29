<template>
  <div>
    <q-markup-table>
      <thead>
        <tr>
          <th class="text-left">{{ lang.ortu_kk }}</th>
          <th class="text-left">{{ lang.ortu_label_ayah }}</th>
          <th class="text-left">{{ lang.ortu_label_ibu }}</th>
          <th class="text-left">{{ lang.ortu_label_telp }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in data" :key="index">
          <td class="text-left">{{ item.parent_family_card }}</td>
          <td class="text-left">{{ item.parent_father_name }}</td>
          <td class="text-left">{{ item.parent_mother_name }}</td>
          <td class="text-left">{{ item.parent_phone_number }}</td>
        </tr>
      </tbody>
    </q-markup-table>
    <div class="q-pa-lg flex flex-center">
      <q-pagination class="flex flex-center"
        v-model="current"
        :max="pageLinks.length"
        input
        @update:model-value="onPaginationUpdate"
      />
    </div>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import locale from '../../mixins/fetch-lang'
import parent from '../../mixins/ac-ortu'

export default defineComponent({
  name: 'ParentTable',
  mixins: [locale, parent],  
  data () {
    return {}
  },
  mounted () {
    setTimeout(() => {
      this.getOrtu()
      this.fetchLang('AdminOrtu')
    }, 500)
  },
  setup () {
    return {
      
    }
  }
})
</script>