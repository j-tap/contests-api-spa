<template>
  <Form @submit:form="onSubmit">
    <Input 
      v-model="form.name.value"
      :parameters="form.name.parameters"
      :errors="errors.name"
    />
  </Form>
</template>

<script>
import formsEntity from '@/mixins/components/formsEntity'

import Form from '@/components/helpers/Form'
import Input from '@/components/ui/Input'

export default {
	name: 'FormCompany',

  components: {
    Form,
		Input,
	},

  mixins: [
    formsEntity,
  ],

  props: {
    modelValue: {
      type: Object,
      default: () => ({}),
    },
    errors: {
      type: Object,
      default: () => ({}),
    },
  },

  data() {
    return {
      nameEntity: 'company',
      formModel: {
        name: {
          value: null,
          parameters: {
            label: 'Название',
          },
        },
      },
    }
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
