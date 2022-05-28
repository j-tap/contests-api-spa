<template>
  <div class="accordion">
    <slot/>
  </div>
</template>

<script>
export default {
	name: 'Accordion',

  props: {
    modelValue: {
      type: Array,
      default: () => [],
    },
  },

  data ()
  {
    return {
      accordion: {
        current: this.modelValue,
        count: 0,
      },
    }
  },

  provide ()
  {
    return {
      accordion: this.accordion,
    }
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
