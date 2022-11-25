<template>
  <q-card :class="`bg-${color}`">
    <q-card-section>
      <div class="row">
        <div class="col-9 title">{{ title }}</div>
        <div class="col-3 text-center number">{{ number }}</div>
      </div>
    </q-card-section>
  </q-card>
</template>

<style lang="sass" scoped>
.title 
  margin-top: 10px
  font-size: 1.2em
  font-weight: 300

.number
  font-size: 2em
  font-weight: thin
  border-radius: 0 4px 4px 0

.title, .number
  color: #fff
</style>

<script>
export default {
  props: ['title', 'number', 'color'],
  setup(props) {
    return {}
  }
}
</script>