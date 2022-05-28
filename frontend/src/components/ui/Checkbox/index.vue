<template>
  <Control
    class="form-checkbox"
    :params="params"
    :errors="errors"
  >
    <input
      v-model="value"
      :checked="!!value"
      :id="params.id"
      class="form-check-input"
      type="checkbox"
      :aria-describedby="`${params.id}--help`"
      :autocomplete="params.autocomplete"
    >
  </Control>
</template>

<script>
import Control from '@/components/helpers/Control'

let indexInstance = 0

export default {
	name: 'Checkbox',

  components: {
    Control,
	},

  props: {
    modelValue: {
      type: [Boolean, Number],
      default: false,
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
        id: `formCheckbox-${indexInstance}`,
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
        return this.modelValue
      },
      set (value)
      {
        this.updateValue(value)
      }
    },
  },

  created() {
    indexInstance++
  },

  methods: {
		updateValue (value)
    {
			this.$emit('update:modelValue', value ? 1 : 0)
		},
	}
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
