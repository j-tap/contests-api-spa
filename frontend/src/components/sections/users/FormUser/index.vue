<template>
  <Form @submit:form="onSubmit">
    <Input
      v-if="form.name.display"
      v-model="form.name.value"
      :parameters="form.name.parameters"
      :errors="errors.name"
    />
    <Input
      v-if="form.name.display"
      v-model="form.email.value"
      :parameters="form.email.parameters"
      :errors="errors.email"
    />
    <Input
      v-if="form.name.display"
      v-model="form.password.value"
      :parameters="form.password.parameters"
      :errors="errors.password"
    />
    <Input
      v-if="form.name.display"
      v-model="form.password_confirmation.value"
      :parameters="form.password_confirmation.parameters"
      :errors="errors.password_confirmation"
    />
    <Select
      v-model="form.role_id.value"
      :parameters="form.role_id.parameters"
      :errors="errors.role_id"
    />
    <Select
      v-model="form.companies.value"
      :parameters="form.companies.parameters"
      :errors="errors.companies"
    />
  </Form>
</template>

<script>
import { mergeObjects } from '@/libs/helpers/convertData'
import formsEntity from '@/mixins/components/formsEntity'

import Form from '@/components/helpers/Form'
import Input from '@/components/ui/Input'
import Select from '@/components/ui/Select'

export default {
	name: 'FormUser',

  components: {
    Form,
		Input,
    Select,
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
    companies: {
      type: Array,
      default: () => [],
    },
    roles: {
      type: Array,
      default: () => [],
    },
    edit: {
      type: Boolean,
      default: false,
    },
  },

  data() {
    return {
      nameEntity: 'user',
      formModel: {
        name: {
          value: null,
          display: !this.edit,
          parameters: {
            label: 'Имя',
          },
        },
        email: {
          value: null,
          display: !this.edit,
          parameters: {
            label: 'E-mail',
            type: 'email',
          },
        },
        password: {
          value: null,
          display: !this.edit,
          parameters: {
            label: 'Пароль',
            type: 'password',
            autocomplete: 'new-password',
          },
        },
        password_confirmation: {
          value: null,
          display: !this.edit,
          parameters: {
            label: 'Подтверждение пароля',
            type: 'password',
            autocomplete: 'new-password',
          },
        },
        role_id: {
          value: null,
          parameters: {
            label: 'Роль',
            items: [],
          },
        },
        companies: {
          value: null,
          parameters: {
            label: 'Компании',
            multiple: true,
            items: [],
          },
        },
      },
    }
  },

  computed: {
    form ()
    {
      const result = mergeObjects(this.formModel, this.modelValue)
      result.companies.parameters.items = this.companies
      result.role_id.parameters.items = this.roles
      return result
    },
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
