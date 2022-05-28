<template>
  <component
    :is="to ? 'router-link' : 'div'"
    :to="to"
    class="card"
  >
    <div class="card-body">
      <div v-if="title || $slots.headerRight" class="d-flex justify-content-between align-items-center mb-2">
        <h2 v-if="title" class="h4 card-title mb-3">{{ title }}</h2>
        <div>
          <slot name="header-right"/>
        </div>
      </div>
      
      <slot/>

    </div>
    <div v-if="$slots.footer" class="card-footer">
      <slot name="footer"/>
    </div>
  </component>
</template>

<script>
export default {
	name: 'Card',

  props: {
    to: {
      type: Object,
      default: null,
    },
    title: {
      type: String,
      default: null,
    },
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
