<template>
  <div class="settings-fields">
    <Form v-if="listForm.length" @submit:form="onSubmit">
      <component
        v-for="(fieldName, ind) in listForm"
        :key="`setting-${ind}`"
        :is="form[fieldName].component"
        v-model="form[fieldName].value"
        :parameters="form[fieldName].parameters"
      />
    </Form>
    <div v-else>Нет настроек</div>
  </div>
</template>

<script>
import Input from '@/components/ui/Input'
import Form from '@/components/helpers/Form'

export default {
  name: 'FormSettingFields',

  components: {
		Input,
    Form,
	},

  props: {
    value: {
      type: Array,
      default: () => [],
    },
  },

  data() {
    return {
      nameEntity: 'settings',
      components: {
        text: 'Input',
      },
    }
  },

  computed: {
    listForm ()
    {
      return Object.keys(this.form)
    },
    form ()
    {
      const result = {}
      this.value.forEach(o =>
      {
        result[o.key] = {
          component: this.components[o.setting_type.name],
          value: o.value,
          parameters: {
            id: o.id,
            key: o.key,
            type: o.setting_type.name,
            label: o.name,
            hint: o.description,
          },
        }
      })
      return result
    },
  },

  methods: {
    onSubmit ()
    {
      this.$emit(`submit:form-settings`, this.form)
    },
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
