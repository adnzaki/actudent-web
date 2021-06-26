<template>
  <div class="col-12 col-md-3 q-pr-xs q-mt-sm">
    <q-select
      outlined
      v-model="model"
      use-input
      input-debounce="0"
      :options="options"
      dense
      @filter="filterFn"
      @update:model-value="getStudentsByClass"
    >
      <template v-slot:no-option>
        <q-item>
          <q-item-section class="text-grey">
            No results
          </q-item-section>
        </q-item>
      </template>
    </q-select>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'

export default {
  name: 'ClassOptions',
  inject: ['textLang'],
  data() {
    return {
      options: [],
      stringOptions: [],
      model: {},
    }
  },
  created() {
    setTimeout(() => {
      this.createClassList()
    }, 3000);
  },
  methods: {
    ...mapMutations('student', ['getClassGroup']),
    ...mapActions('student', ['getStudentsByClass']),
    createClassList() {    
      let modelValue = {
        label: this.getLang.siswa_semua_kelas,
        value: 'null'
      }

      this.model = modelValue
      this.stringOptions = [modelValue]

      this.getClassGroup()

      setTimeout(() => {
        this.classGroupList.forEach(item => {
          this.stringOptions.push({
            label: item.grade_name,
            value: item.grade_id
          })
        }) 
  
        this.options = this.stringOptions        
      }, 2000);
    },
    filterFn(val, update, abort) {
      update(() => {
        const needle = val.toLowerCase()
        this.options = this.stringOptions.filter(v => v.label.toLowerCase().indexOf(needle) > -1)
      })
    }
  },
  computed: {
    ...mapState('student', {
      classGroupList: state => state.classGroupList
    }),
    getLang() {
      return this.textLang.value
    }
  },
  
}
</script>