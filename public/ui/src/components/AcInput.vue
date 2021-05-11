<template>
  <q-input outlined
    :type="type"
    :label="label" dense 
    v-model="input" 
    :suffix="suffix">
    <slot></slot>
  </q-input>
  <small class="text-negative" style="margin-left: 30px">
    {{ error }}
  </small>
</template>

<script>
export default {
  name: 'AcInput',
  props: ['label', 'error', 'input', 'suffix', 'type'],
}
</script>
