<template>
  <Form @submit:form="onSubmit">
    <Input
      v-model="form.name.value"
      :parameters="form.name.parameters"
      :errors="errors.name"
    />
    <Input
      v-model="form.key.value"
      :parameters="form.key.parameters"
      :errors="errors.key"
    />
    <Select
      v-model="form.setting_type_id.value"
      :parameters="form.setting_type_id.parameters"
      :errors="errors.setting_type_id"
    />
    <Input 
      v-model="form.value.value"
      :parameters="form.value.parameters"
      :errors="errors.value"
    />
    <Select
      v-model="form.company_id.value"
      :parameters="form.company_id.parameters"
      :errors="errors.company_id"
    />
    <Select
      v-model="form.contest_id.value"
      :parameters="form.contest_id.parameters"
      :errors="errors.contest_id"
    />
    <Input
      v-model="form.description.value"
      :parameters="form.description.parameters"
      :errors="errors.description"
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
	name: 'FormSetting',

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
    edit: {
      type: Boolean,
      default: false,
    },
    errors: {
      type: Object,
      default: () => ({}),
    },
    settingsTypes: {
      type: Array,
      default: () => [],
    },
    companies: {
      type: Array,
      default: () => [],
    },
    contests: {
      type: Array,
      default: () => [],
    },
  },

  data()
  {
    return {
      nameEntity: 'setting',
      formModel: {
        name: {
          value: null,
          parameters: {
            label: 'Название',
          },
        },
        key: {
          value: null,
          parameters: {
            label: 'Ключ поля',
            readonly: this.edit,
          },
        },
        setting_type_id: {
          value: 1,
          parameters: {
            label: 'Тип поля',
            items: [],
          },
        },
        value: {
          value: null,
          parameters: {
            label: 'Значение',
          },
        },
        company_id: {
          value: null,
          parameters: {
            label: 'Компания',
            items: [],
          },
        },
        contest_id: {
          value: null,
          parameters: {
            label: 'Розыгрыш',
            items: [],
            _default: false,
          },
        },
        description: {
          value: null,
          parameters: {
            label: 'Описание поля',
          },
        },
      },
    }
  },

  computed: {
    currentCompanyId ()
    {
      return this.form && this.form.company_id ? this.form.company_id.value : 0
    },
    contestsOfCompany ()
    {
      return [
        { value: null, text: 'нет' },
        ...this.contests.filter(o => o.company_id === this.currentCompanyId),
      ]
    },

    form ()
    {
      const result = mergeObjects(this.formModel, this.modelValue)
      result.setting_type_id.parameters.items = this.settingsTypes
      result.company_id.parameters.items = this.companies
      result.contest_id.parameters.items = this.contestsOfCompany
      return result
    },
  },

}
</script>
