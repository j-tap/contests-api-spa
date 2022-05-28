<template>
  <Form @submit:form="onSubmit">
    <Input
      v-model="form.name.value"
      :parameters="form.name.parameters"
      :errors="errors.name"
    />
    <!-- <Input
      v-model="form.key.value"
      :parameters="form.key.parameters"
      :errors="errors.key"
    /> -->
  </Form>
</template>

<script>
import formsEntity from '@/mixins/components/formsEntity'

import Form from '@/components/helpers/Form'
import Input from '@/components/ui/Input'

export default {
	name: 'FormTemplate',

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
      nameEntity: 'template',
      formModel: {
        name: {
          value: null,
          parameters: {
            label: 'Название',
          },
        },
        // key: {
        //   value: null,
        //   parameters: {
        //     label: 'Ключ для лендинга',
        //   },
        // },
      },
    }
  },

}
</script>

<style scoped lang="scss" src="./style.scss"></style>
