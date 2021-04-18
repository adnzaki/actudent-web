<template>
  <div class="q-pa-md">    
    <q-card class="my-card">
      <q-card-section>
        <div class="text-h6">Our Changing Planet</div>
        <div class="text-subtitle2">by John Doe</div>
      </q-card-section>

      <q-markup-table>
        <thead>
          <tr>
            <th class="text-left">{{ lang.ortu_kk }}</th>
            <th class="text-right">{{ lang.ortu_label_ayah }}</th>
            <th class="text-right">{{ lang.ortu_label_ibu }}</th>
            <th class="text-right">{{ lang.ortu_label_telp }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data">
            <td class="text-left">{{ item.parent_family_card }}</td>
            <td class="text-right">{{ item.parent_father_name }}</td>
            <td class="text-right">{{ item.parent_mother_name }}</td>
            <td class="text-right">{{ item.parent_phone_number }}</td>
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
    </q-card>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import locale from '../../mixins/fetch-lang'
import parent from '../../mixins/ac-ortu'

export default defineComponent({
  name: 'ParentMain',
  mixins: [locale, parent],  
  data () {
    return {}
  },
  mounted () {
    setTimeout(() => {
      this.getOrtu()
      this.fetchLang('Admin')
      this.fetchLang('AdminOrtu')
    }, 500)
  },
  setup () {
    return {
      
    }
  }
})
</script>
