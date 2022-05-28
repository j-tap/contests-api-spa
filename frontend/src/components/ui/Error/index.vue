<template>
  <div class="invalid-feedback d-block">
    <div
      v-for="(error, i) in errors"
      :key="`control-error-${i}`"
    >{{ error }}</div>
  </div>
</template>

<script>
export default {
	name: 'Error',

  props: {
    value: {
      type: [String, Array],
      default: null,
    }
  },

  computed: {
    errors ()
    {
      let result = []

      if (this.value)
      {
        if (typeof this.value === 'string')
        {
          result.push(this.value)
        }
        else
        {
          result = [...this.value]
        }
      }

      return result
    },
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
