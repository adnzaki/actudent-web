<template>
  <q-input outlined :label="$t('kelas_wali')" dense 
    v-model="model" @update:model-value="$store.commit('grade/searchTeacher', model)" />
  <q-card bordered v-if="searchResults.length > 0">
    <q-scroll-area style="height: 100px">
      <q-list bordered separator class="q-mt-xs" dense>
        <q-item clickable v-ripple v-for="(item, key) in searchResults" :key="key"
          @click="selectData(item)">
          <q-item-section>
            {{ item.staff_name }} ({{item.staff_nik}})
          </q-item-section>
        </q-item>
      </q-list>
    </q-scroll-area>
  </q-card>
  <error :label="error.teacher_id" />
  <q-input outlined :label="$t('kelas_label_walikelas')" dense
    v-model="$store.state.grade.selectedTeacher.name" disable />
</template>

<script>
import { computed, ref } from 'vue'
import { useStore } from 'vuex'

export default {
  name: 'SearchTeacher',
  setup() {
    const store = useStore()
    const model = ref('')
    const searchResults = computed(() => store.state.grade.teachers)

    const selectData = data => {
      store.commit('grade/selectTeacher', data)
      model.value = ''
    }

    const error = computed(() => store.state.grade.error)

    return {
      model,
      selectData,
      error,
      searchResults
    }
  } 
}
</script>