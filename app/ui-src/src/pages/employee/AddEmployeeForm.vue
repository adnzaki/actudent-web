<template>
  <q-dialog
    no-backdrop-dismiss
    v-model="store.showAddForm"
    @before-show="formOpen"
    :maximized="maximizedDialog()"
    @hide="store.helper.filename = ''"
  >
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">
          {{ $t("staff_form_add_title") }}
        </div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          <q-input
            outlined
            :label="$t('staff_input_id')"
            minlength="10"
            maxlength="10"
            dense
            v-model="formData.staff_nik"
          />
          <ac-error :label="error.staff_nik" />

          <q-input
            outlined
            :label="$t('staff_label_nama')"
            dense
            v-model="formData.staff_name"
          />
          <ac-error :label="error.staff_name" />

          <q-input
            outlined
            :label="$t('staff_label_telp')"
            minlength="11"
            maxlength="13"
            dense
            v-model="formData.staff_phone"
          />
          <ac-error :label="error.staff_phone" />

          <div>
            {{ $t("staff_label_jenis") }}
          </div>
          <div class="row q-mb-md">
            <div class="col-6">
              <q-radio
                v-model="formData.staff_type"
                val="teacher"
                :label="$t('staff_input_guru')"
              />
            </div>
            <div class="col-6">
              <q-radio
                v-model="formData.staff_type"
                val="staff"
                label="Staff"
              />
            </div>
          </div>

          <q-input
            outlined
            :label="$t('staff_label_jabatan')"
            dense
            v-model="formData.staff_title"
          />
          <ac-error :label="error.staff_title" />

          <q-file
            color="grey-3"
            outlined
            dense
            v-model="formData.staff_photo"
            :label="$t('staff_label_photo')"
            @update:model-value="encodeImage"
            accept="image/jpeg, image/png"
          >
            <template v-slot:prepend>
              <q-icon name="cloud_upload" />
            </template>
          </q-file>

          <employee-photo />

          <ac-error :label="error.staff_photo" />
          <ac-error :label="error.featured_image" />

          <q-input
            outlined
            :label="$t('user_label_email')"
            dense
            v-model="formData.user_email"
          />
          <ac-error :label="error.user_email" />

          <q-input
            outlined
            :label="$t('user_pass')"
            dense
            v-model="formData.user_password"
            type="password"
          />
          <ac-error :label="error.user_password" />

          <q-input
            outlined
            :label="$t('user_pass_confirm')"
            dense
            v-model="formData.user_password_confirm"
            type="password"
          />
          <ac-error :label="error.user_password_confirm" />
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
import { ref, onMounted, computed } from "vue";
import { useEmployeeStore } from "src/stores/employee";
import { school, getSchool } from "../../composables/common";
import { maximizedDialog, cardDialog } from "../../composables/screen";

export default {
  setup() {
    const store = useEmployeeStore();

    const formData = ref({
      staff_nik: "",
      staff_name: "",
      staff_phone: "",
      staff_type: "teacher",
      staff_title: "",
      staff_photo: null,
      user_name: "",
      user_email: "",
      user_password: "",
    });

    onMounted(getSchool);

    const save = () => {
      //let pattern = /(\s|\W+)/ig
      //formData.value.user_email = formData.value.user_email.replace(pattern, '')
      store.save({
        data: formData.value,
        edit: false,
        id: null,
      });
    };

    const formOpen = () => {
      const saveStatus = computed(() => store.saveStatus);
      if (saveStatus.value === 200) {
        formData.value = {
          staff_nik: "",
          staff_name: "",
          staff_phone: "",
          staff_type: "teacher",
          staff_title: "",
          staff_photo: null,
          user_name: "",
          user_email: "",
          user_password: "",
        };

        store.saveStatus = 500;
      }
    };

    const encodeImage = (val) => {
      store.uploadImage(val);
    };

    return {
      save,
      store,
      school,
      formOpen,
      formData,
      cardDialog,
      encodeImage,
      maximizedDialog,
      error: computed(() => store.error),
      disableSaveButton: computed(() => store.helper.disableSaveButton),
    };
  },
};
</script>
