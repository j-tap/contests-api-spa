<template>
  <label
    :for="id"
    class="form-label"
  >
    <slot/>
  </label>
</template>

<script>
export default {
	name: 'Label',

  props: {
    id: {
      type: [String, Number],
      default: null,
    }
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
