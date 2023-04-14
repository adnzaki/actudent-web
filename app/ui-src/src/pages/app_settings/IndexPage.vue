<template>
  <div :class="wrapperPadding()">
    <language-setting />
    <theme-setting />
  </div>
</template>

<script>
import { wrapperPadding } from "src/composables/screen";
import LanguageSetting from "./LanguageSetting.vue";
import ThemeSetting from "./ThemeSetting.vue";

export default {
  components: {
    LanguageSetting,
    ThemeSetting,
  },
  setup() {
    return {
      wrapperPadding,
    };
  },
};
</script>
