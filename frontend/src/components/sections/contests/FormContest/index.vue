<template>
  <Form @submit:form="onSubmit">
    <Checkbox
      v-model="form.active.value"
      :parameters="form.active.parameters"
      :errors="errors.active"
    />
    <Select
      v-model="form.status_id.value"
      :parameters="form.status_id.parameters"
      :errors="errors.status_id"
    />
    <Input 
      v-model="form.name.value"
      :parameters="form.name.parameters"
      :errors="errors.name"
    />
    <Select
      v-model="form.landing_template_id.value"
      :parameters="form.landing_template_id.parameters"
      :errors="errors.landing_template_id"
    />
    <div class="row">
      <div class="col-sm-6">
        <Datetime 
          v-model="form.date_from.value"
          :parameters="form.date_from.parameters"
          :errors="errors.date_from"
        />
      </div>
      <div class="col-sm-6">
        <Datetime 
          v-model="form.date_to.value"
          :parameters="form.date_to.parameters"
          :errors="errors.date_to"
        />
      </div>
    </div>
  </Form>
</template>

<script>
import { mergeObjects } from '@/libs/helpers/convertData'

import formsEntity from '@/mixins/components/formsEntity'

import Form from '@/components/helpers/Form'
import Input from '@/components/ui/Input'
import Select from '@/components/ui/Select'
import Checkbox from '@/components/ui/Checkbox'
import Datetime from '@/components/ui/Datetime'

export default {
	name: 'FormContest',

  components: {
    Form,
		Input,
    Select,
    Checkbox,
    Datetime,
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

    landingTemplates: {
      type: Array,
      default: () => [],
    },
    statuses: {
      type: Array,
      default: () => [],
    },
  },

  data() {
    return {
      nameEntity: 'contest',
      formModel: {
        active: {
          value: false,
          parameters: {
            label: 'Активный',
            hint: 'Активный - разрешает регистрацию новых участников',
          },
        },
        status_id: {
          value: 1,
          parameters: {
            label: 'Рабочий статус',
            hint: 'Статус работы над розыгрышем для менеджеров',
            items: [],
          },
        },
        name: {
          value: null,
          parameters: {
            label: 'Название',
          },
        },
        landing_template_id: {
          value: null,
          parameters: {
            label: 'Шаблон сайта',
            items: [],
          },
        },
        date_from: {
          value: null,
          parameters: {
            label: 'Время начала',
          },
        },
        date_to: {
          value: null,
          parameters: {
            label: 'Время завершения',
          },
        },
      },
    }
  },

  computed: {
    form ()
    {
      const result = mergeObjects(this.formModel, this.modelValue)
      result.landing_template_id.parameters.items = this.landingTemplates
      result.status_id.parameters.items = this.statuses
      return result
    },
  },

}
</script>
