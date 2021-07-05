<template>
  <q-input outlined :label="getLang.siswa_input_kk" dense 
    v-model="model" @update:model-value="$store.commit('student/searchParents', model)" />
  <q-card bordered v-if="searchResults.length > 0">
    <q-scroll-area style="height: 100px">
      <q-list bordered separator class="q-mt-xs" dense>
        <q-item clickable v-ripple v-for="(item, key) in searchResults" :key="key"
          @click="selectData(item)">
          <q-item-section>
            {{ item.parent_father_name }} / {{ item.parent_mother_name }} ({{ item.parent_family_card }})
          </q-item-section>
        </q-item>
      </q-list>
    </q-scroll-area>
  </q-card>
  <error :label="error.parent_id" />
  <q-input outlined :label="getLang.siswa_label_ayah" dense
    v-model="$store.state.student.selectedParent.father" disable />
  <q-input outlined :label="getLang.siswa_label_ibu" dense class="q-mt-lg"
    v-model="$store.state.student.selectedParent.mother" disable />  
</template>

<script>
import { inject, computed, ref } from 'vue'
import { useStore } from 'vuex'

export default {
  name: 'SearchParents',
  setup() {
    const store = useStore()
    const getLang = computed(() => inject('textLang')).value
    const model = ref('')
    const searchResults = computed(() => store.state.student.family)

    const selectData = data => {
      store.commit('student/selectParent', data)
      model.value = ''
    }

    const error = computed(() => store.state.student.error)

    return {
      getLang,
      model,
      selectData,
      error,
      searchResults
    }
  } 
}
</script>