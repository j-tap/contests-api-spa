<template>
  <div :class="['form-unit', 'mt-0',, 'mb-3', { 'is-invalid': errors.length }]">
    <div class="form-unit__field-wrap">
      <Label v-if="params.label" :id="params.id">{{ params.label }}</Label>
      <slot/>
    </div>
    <Hint>{{ params.hint }}</Hint>
    <Error :value="errors"/>
  </div>
</template>

<script>
import Label from '@/components/ui/Label'
import Hint from '@/components/ui/Hint'
import Error from '@/components/ui/Error'

export default {
	name: 'Control',

  components: {
    Label,
    Hint,
    Error,
	},

  props: {
    params: {
			type: Object,
			default: () => ({})
		},
    errors: {
			type: Array,
			default: () => [],
		},
  },

  methods: {
    onSubmit ()
    {
      this.$emit('submit:form')
    },
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
