<!-- <template>
  <q-input outlined :label="$t('kelas_wali')" dense 
    v-model="model" @update:model-value="store.searchTeacher(model)" />
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
    v-model="store.selectedTeacher.name" disable />
</template>

<script>
import { computed, ref } from 'vue'
import { useClassStore } from 'src/stores/class'

export default {
  name: 'SearchTeacher',
  setup() {
    const store = useClassStore()
    const model = ref('')
    const searchResults = computed(() => store.teachers)

    const selectData = data => {
      store.selectTeacher(data)
      model.value = ''
    }

    const error = computed(() => store.error)

    return {
      store,
      model,
      selectData,
      error,
      searchResults
    }
  } 
}
</script> -->