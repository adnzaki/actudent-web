<template>
  <q-card :class="`bg-${color}`">
    <q-card-section>
      <div class="row">
        <div class="col-9 title">{{ title }}</div>
        <div class="col-3 text-center number" v-if="icon === null">
          {{ number }}
        </div>
        <div class="col-3 text-center icon" v-else>
          <q-icon :name="icon" style="margin-top: -5px" />
        </div>
      </div>
    </q-card-section>
  </q-card>
</template>

<style lang="sass" scoped>
.title
  margin-top: 14px
  font-size: 1.2em
  font-weight: 300

.number, .icon
  font-size: 2.5em

.number
  font-weight: thin
  border-radius: 0 4px 4px 0

.icon
  padding: 0 !important
  font-weight: thin
  border-radius: 0 4px 4px 0

.title, .number, .icon
  color: #fff
</style>

<script setup>
const props = defineProps({
  title: String,
  number: {
    type: Number,
    required: false,
  },
  color: String,
  icon: {
    type: [String],
    default: null,
    required: false,
  },
})
</script>
