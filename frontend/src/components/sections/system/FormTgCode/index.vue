<template>
  <Form @submit:form="onSubmit">
    <Input 
      v-model="form.code.value"
      :parameters="form.code.parameters"
      :errors="errors.code"
    />
  </Form>
</template>

<script>
import formsEntity from '@/mixins/components/formsEntity'

import Form from '@/components/helpers/Form'
import Input from '@/components/ui/Input'

export default {
	name: 'FormTgCode',

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
      nameEntity: 'tgcode',
      formModel: {
        code: {
          value: null,
          parameters: {
            label: 'Проверочный код',
          },
        },
      },
    }
  },
}
</script>
