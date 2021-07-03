<template>
  <q-input outlined :label="getLang.siswa_input_kk" dense 
    v-model="model" @update:model-value="$store.commit('student/searchParents', model)" />
  <q-card bordered v-if="family.length > 0">
    <q-scroll-area style="height: 100px">
      <q-list bordered separator class="q-mt-xs" dense>
        <q-item clickable v-ripple v-for="(item, key) in family" :key="key"
          @click="selectParent(item)">
          <q-item-section>
            {{ item.parent_father_name }} / {{ item.parent_mother_name }} ({{ item.parent_family_card }})
          </q-item-section>
        </q-item>
      </q-list>
    </q-scroll-area>
  </q-card>
  <q-input outlined :label="getLang.siswa_label_ayah" dense class="q-mt-lg"
    v-model="$store.state.student.selectedParent.father" disable />
  <q-input outlined :label="getLang.siswa_label_ibu" dense class="q-mt-lg"
    v-model="$store.state.student.selectedParent.mother" disable />
  <error :label="error.parent_id" />
</template>

<script>
import { inject, computed, ref } from 'vue'
import { useStore, mapMutations, mapState } from 'vuex'

export default {
  name: 'SearchParents',
  setup() {
    const store = useStore()
    const getLang = computed(() => inject('textLang')).value
    const model = ref('')
    const family = computed(() => store.state.student.family)

    const selectParent = data => {
      store.commit('student/selectParent', data)
      model.value = ''
    }

    const error = computed(() => store.state.student.error)

    return {
      getLang,
      model,
      selectParent,
      error,
      family
    }
  } 
}
</script>