<template>
  <Form submit-text="Войти" @submit:form="onSubmit">
    <Input v-model="form.email.value" :parameters="form.email.parameters" />
    <Input v-model="form.password.value" :parameters="form.password.parameters" />
  </Form>
</template>

<script>
import Form from '@/components/helpers/Form'
import Input from '@/components/ui/Input'

export default {
	name: 'FormLogin',

  components: {
    Form,
		Input,
	},

  data() {
    return {
      form: {
        email: {
          value: null,
          parameters: {
            label: 'E-mail',
            type: 'email',
            autocomplete: 'on',
          },
        },
        password: {
          value: null,
          parameters: {
            label: 'Password',
            type: 'password',
            autocomplete: 'on',
          },
        },
      },
    }
  },

  methods: {
    onSubmit ()
    {
      this.$emit('submit:form-login', this.form)
    },
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
