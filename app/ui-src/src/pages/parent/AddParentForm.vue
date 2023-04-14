<template>
  <q-dialog
    no-backdrop-dismiss
    v-model="store.showAddForm"
    @before-show="formOpen"
    :maximized="maximizedDialog()"
  >
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">
          {{ $t("ortu_form_add_title") }}
        </div>
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
            v-model="formData.parent_family_card"
          />
          <ac-error :label="error.parent_family_card" />

          <q-input
            outlined
            :label="$t('ortu_label_ayah')"
            dense
            v-model="formData.parent_father_name"
          >
            <q-radio v-model="formData.user_name" val="1">
              <q-tooltip
                anchor="center left"
                self="center right"
                :offset="[10, 10]"
              >
                {{ $t("ortu_set_acc_name") }}
              </q-tooltip>
            </q-radio>
          </q-input>
          <ac-error :label="error.parent_father_name" />

          <q-input
            outlined
            :label="$t('ortu_label_ibu')"
            dense
            v-model="formData.parent_mother_name"
          >
            <q-radio v-model="formData.user_name" val="2">
              <q-tooltip
                anchor="center left"
                self="center right"
                :offset="[10, 10]"
              >
                {{ $t("ortu_set_acc_name") }}
              </q-tooltip>
            </q-radio>
          </q-input>
          <ac-error :label="error.parent_mother_name" />

          <q-input
            outlined
            :label="$t('ortu_label_telp')"
            minlength="11"
            maxlength="13"
            dense
            v-model="formData.parent_phone_number"
          />
          <ac-error :label="error.parent_phone_number" />

          <q-input
            outlined
            :label="$t('user_email')"
            dense
            v-model="formData.user_email"
            :suffix="`@${school.school_domain}`"
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
import { ref, onMounted } from "vue";
import { useParentStore } from "src/stores/parent";
import { school, getSchool } from "../../composables/common";
import { maximizedDialog, cardDialog } from "../../composables/screen";

export default {
  setup() {
    const store = useParentStore();

    let formData = ref({
      parent_family_card: "",
      parent_father_name: "",
      parent_mother_name: "",
      parent_phone_number: "",
      user_email: "",
      user_password: "",
      user_password_confirm: "",
      user_name: "1",
    });

    onMounted(getSchool);

    const save = () => {
      let pattern = /(\s|\W+)/gi;
      formData.value.user_email = formData.value.user_email.replace(
        pattern,
        ""
      );
      store.save({
        data: formData.value,
        edit: false,
        id: null,
      });
    };

    const formOpen = () => {
      if (store.saveStatus === 200) {
        formData.value = {
          parent_family_card: "",
          parent_father_name: "",
          parent_mother_name: "",
          parent_phone_number: "",
          user_email: "",
          user_password: "",
          user_password_confirm: "",
          user_name: "1",
        };

        store.saveStatus = 500;
      }
    };

    return {
      save,
      store,
      school,
      formOpen,
      formData,
      cardDialog,
      maximizedDialog,
      error: store.error,
      disableSaveButton: store.helper.disableSaveButton,
    };
  },
};
</script>
