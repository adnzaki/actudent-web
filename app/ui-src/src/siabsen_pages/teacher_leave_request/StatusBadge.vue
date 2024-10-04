<template>
  <q-badge :color="color" :label="label" />
</template>

<script>
import { t } from 'src/composables/common'
import { computed } from 'vue'

export default {
  props: ['value'],
  setup(props) {
    const status = {
      submitted: t('siabsen_submit_status'),
      approved: t('siabsen_approve_status'),
      rejected: t('siabsen_reject_status')
    }

    const statusColor = {
      submitted: 'yellow-10',
      approved: 'positive',
      rejected: 'negative'
    }

    return {
      label: computed(() => status[props.value]),
      color: computed(() => statusColor[props.value])
    }
  }
}
</script>