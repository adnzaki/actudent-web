<template>
  <q-input
    outlined
    :label="$t('siswa_input_kk')"
    dense
    v-model="model"
    @update:model-value="store.searchParents(model)"
  />
  <q-card bordered v-if="searchResults.length > 0">
    <q-scroll-area style="height: 150px">
      <q-list bordered separator class="q-mt-xs" dense>
        <q-item
          clickable
          v-ripple
          v-for="(item, key) in searchResults"
          :key="key"
          @click="selectData(item)"
        >
          <q-item-section>
            {{ item.parent_father_name }} / {{ item.parent_mother_name }} ({{
              item.parent_family_card
            }})
          </q-item-section>
        </q-item>
      </q-list>
    </q-scroll-area>
  </q-card>
  <ac-error :label="error.parent_id" />
  <q-input
    outlined
    :label="$t('siswa_label_ayah')"
    dense
    v-model="store.selectedParent.father"
    disable
  />
  <q-input
    outlined
    :label="$t('siswa_label_ibu')"
    dense
    class="q-mt-lg"
    v-model="store.selectedParent.mother"
    disable
  />
</template>

<script>
import { computed, ref } from 'vue'
import { useStudentStore } from 'src/stores/student'

export default {
  setup() {
    const store = useStudentStore()
    const model = ref('')
    const searchResults = computed(() => store.family)

    const selectData = (data) => {
      store.selectParent(data)
      model.value = ''
    }

    const error = computed(() => store.error)

    return {
      store,
      model,
      selectData,
      error,
      searchResults,
    }
  },
}
</script>
