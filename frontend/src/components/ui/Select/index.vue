<template>
  <Control
    :params="params"
    :errors="errors"
  >
    <select
      v-model="value"
      :id="params.id"
      class="form-select"
      v-bind="properties"
      :aria-describedby="`${params.id}--help`"
      @change="onChange"
    >
      <option v-if="params._default" :value="null" disabled>Выберите...</option>
      <option
        v-for="(item, i) in params.items"
        :key="`option-${i}`"
        :value="item.value"
      >{{ item.text }}</option>
    </select>
  </Control>
</template>

<script>
import Control from '@/components/helpers/Control'

let indexInstance = 0

export default {
	name: 'Select',

  components: {
    Control,
	},

  props: {
    modelValue: {
      type: [String, Number, Array, Boolean, null],
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
        id: `formSelect-${indexInstance}`,
        multiple: false,
        items: [],
        _default: true,
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

    properties ()
    {
      const result = {}

      if (this.params.multiple)
      {
        result.multiple = true
      }

      return result
    }
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
