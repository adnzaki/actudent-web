<template>
  <q-dialog v-model="$store.state.parent.showEditForm" :maximized="maximizedDialog()">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ getLang.ortu_edit_title }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section :style="cardSection()" class="scroll">
        <q-form class="q-gutter-xs">
          <q-input outlined :label="getLang.ortu_kk" minlength="16" maxlength="16" dense 
            v-model="$store.state.parent.detail.parent_family_card" />
          <error :label="error.parent_family_card" />
          
          <q-input outlined :label="getLang.ortu_label_ayah" dense 
            v-model="$store.state.parent.detail.parent_father_name">
          </q-input>
          <error :label="error.parent_father_name" />

          <q-input outlined :label="getLang.ortu_label_ibu" dense 
            v-model="$store.state.parent.detail.parent_mother_name">
          </q-input>
          <error :label="error.parent_mother_name" />

          <q-input outlined :label="getLang.ortu_label_telp" minlength="11" maxlength="13" dense 
            v-model="$store.state.parent.detail.parent_phone_number" 
          />
          <error :label="error.parent_phone_number" />

          <p v-if="children.length > 0">{{ getLang.ortu_daftar_anak }}:</p>
          <q-list bordered v-if="children.length > 0">
            <q-item v-for="(item, index) in children" :key="index">
              <q-item-section avatar>
                <q-avatar color="primary" text-color="white">
                  {{ item.student_name.substr(0, 1) }}
                </q-avatar>
              </q-item-section>
              <q-item-section>  
                <q-item-label>{{ item.student_name }}</q-item-label>
                <q-item-label caption lines="1">NIS: {{ item.student_nis }}</q-item-label>
              </q-item-section>
            </q-item>
          </q-list>

        </q-form>
      </q-card-section>
      <q-separator />
      <q-card-actions align="right">
        <q-btn flat :label="getLang.tutup" color="negative" v-close-popup />
        <q-btn :label="getLang.simpan" :disable="disableSaveButton" @click="save" color="primary" padding="8px 20px" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { ref, onMounted, watch, computed, inject } from 'vue'
import { school, getSchool } from '../../composables/common'
import { maximizedDialog, cardDialog, cardSection } from '../../composables/screen'
import { mapState, useStore } from 'vuex'

export default {
  name: 'EditParentForm',
  components: {
    Error
  },
  computed: {
    ...mapState('parent', {
      error: state => state.error,
      disableSaveButton: state => state.helper.disableSaveButton,
      children: state => state.children
    })
  },
  setup() {
    const store = useStore()

    const getLang = computed(() => inject('textLang')).value

    onMounted(getSchool)
    
    const save = () => {
      store.dispatch('parent/save', {
        data: store.state.parent.detail,
        lang: getLang.value,
        edit: true,
        id: store.state.parent.detail.parent_id
      })
    }

    let saveStatus = computed(() => store.state.parent.saveStatus)
    watch(saveStatus, () => {
      if(saveStatus.value === 200) {
        store.state.parent.detail = {}
      }
    })

    return {
      school,
      save,
      user_name: ref('1'),
      maximizedDialog, cardDialog, cardSection,
      getLang
    }
  }
}
</script>
