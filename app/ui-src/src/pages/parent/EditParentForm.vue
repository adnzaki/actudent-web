<template>
  <q-dialog
    no-backdrop-dismiss
    v-model="store.showEditForm"
    :maximized="maximizedDialog()"
    @hide="formHide"
  >
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('ortu_edit_title') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          <q-input
            outlined
            :label="$t('ortu_kk')"
            minlength="16"
            maxlength="16"
            dense
            v-model="store.detail.parent_family_card"
          />
          <ac-error :label="error.parent_family_card" />

          <q-input
            outlined
            :label="$t('ortu_label_ayah')"
            dense
            v-model="store.detail.parent_father_name"
          >
          </q-input>
          <ac-error :label="error.parent_father_name" />

          <q-input
            outlined
            :label="$t('ortu_label_ibu')"
            dense
            v-model="store.detail.parent_mother_name"
          >
          </q-input>
          <ac-error :label="error.parent_mother_name" />

          <q-input
            outlined
            :label="$t('ortu_label_telp')"
            minlength="11"
            maxlength="13"
            dense
            v-model="store.detail.parent_phone_number"
          />
          <ac-error :label="error.parent_phone_number" />

          <p v-if="children.length > 0">{{ $t('ortu_daftar_anak') }}:</p>
          <q-list bordered v-if="children.length > 0">
            <q-item v-for="(item, index) in children" :key="index">
              <q-item-section avatar>
                <q-avatar color="primary" text-color="white">
                  {{ item.student_name.substr(0, 1) }}
                </q-avatar>
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ item.student_name }}</q-item-label>
                <q-item-label caption lines="1"
                  >NIS: {{ item.student_nis }}</q-item-label
                >
              </q-item-section>
            </q-item>
          </q-list>
        </q-form>
      </q-card-section>
      <q-separator />
      <q-card-actions align="right">
        <q-btn
          flat
          :label="$t('tutup')"
          v-if="!$q.screen.lt.sm"
          color="negative"
          v-close-popup
        />
        <q-btn
          :label="$t('simpan')"
          class="mobile-form-btn"
          :disable="disableSaveButton"
          @click="save"
          color="primary"
          padding="8px 20px"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { ref, watch, computed } from 'vue'
import { useParentStore } from 'src/stores/parent'
import { maximizedDialog, cardDialog } from '../../composables/screen'

export default {
  setup() {
    const store = useParentStore()

    const save = () => {
      store.save({
        data: store.detail,
        edit: true,
        id: store.detail.parent_id,
      })
    }

    let saveStatus = computed(() => store.saveStatus)
    watch(saveStatus, () => {
      if (saveStatus.value === 200) {
        store.detail = {}
      }
    })

    const formHide = () => {
      store.children = []
    }

    return {
      save,
      store,
      formHide,
      cardDialog,
      maximizedDialog,
      error: store.error,
      user_name: ref('1'),
      children: store.children,
      disableSaveButton: store.helper.disableSaveButton,
    }
  },
}
</script>
