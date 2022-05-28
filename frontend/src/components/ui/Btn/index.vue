<template>
  <button
    :type="type"
    v-bind="properties"
    @click="onClick"
  >
    <slot/>
  </button>
</template>

<script>
export default {
	name: 'Btn',

  props: {
    type: {
			type: String,
			default: 'button',
		},
    size: {
      type: String,
      default: 'md',
    },
    color: {
      type: String,
      default: 'primary',
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },

  computed: {
    properties ()
    {
      const result = {
        class: `button__btn btn btn-${this.color} btn-${this.size}`,
      }
      if (this.disabled)
      {
        result.disabled = true
      }
      return result
    }
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
