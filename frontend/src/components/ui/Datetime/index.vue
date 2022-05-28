<template>
  <Control
    class="form-datetime"
    :params="params"
    :errors="errors"
  >
    <input
      v-model="value"
      :id="params.id"
      type="datetime-local"
      class="form-control"
    >
  </Control>
</template>

<script>
import Control from '@/components/helpers/Control'

let indexInstance = 0

export default {
	name: 'Datetime',

  components: {
    Control,
	},

  props: {
    modelValue: {
      type: String,
      default: null,
    },
    parameters: {
			type: Object,
			default: () => ({}),
		},
    errors: {
			type: Array,
			default: () => [],
		},
  },

  data() {
    return {
      parametersDefault: {
        type: 'text',
        id: `formInput-${indexInstance}`,
        autocomplete: 'off',
      },
    }
  },

  computed: {
    params ()
    {
			return { ...this.parametersDefault, ...this.parameters }
		},

    value: {
      get ()
      {
        const result = this.modelValue ? this.modelValue.replace(' ', 'T') : this.modelValue
        return result
      },
      set (value)
      {
        this.updateValue(value.replace('T', ' '))
      }
    },
  },

  created() {
    indexInstance++
  },

  methods: {
		updateValue (value)
    {
			this.$emit('update:modelValue', value)
		},
	}
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
