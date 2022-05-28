<template>
  <Control
    class="form-input"
    :params="params"
    :errors="errors"
  >
    <input
      v-model="value"
      :id="params.id"
      :type="params.type"
      :readonly="params.readonly"
      class="form-control"
      :aria-describedby="`${params.id}--help`"
      :autocomplete="params.autocomplete"
    >
  </Control>
</template>

<script>
import Control from '@/components/helpers/Control'

let indexInstance = 0

export default {
	name: 'Input',

  components: {
    Control,
	},

  props: {
    modelValue: {
      type: [String, Number, null],
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

  data()
  {
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
			this.$emit('update:modelValue', value)
		},
	}
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
