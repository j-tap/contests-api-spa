<template>
	<LayoutGuestCenter>
    <section class="page-login">
      <div class="page-login__form">
        <h1>Login</h1>
        <div class="d-flex justify-content-center">
          <FormLogin @submit:form-login="login"/>
        </div>
      </div>
    </section>
	</LayoutGuestCenter>
</template>

<script>
import { login } from '@/services/auth'

import LayoutGuestCenter from '@/layouts/LayoutGuestCenter'
import FormLogin from '@/components/sections/auth/FormLogin'

export default {
	name: 'Login',

	components: {
		LayoutGuestCenter,
    FormLogin,
	},

  methods: {
    async login (form)
    {
      const { success } = await login(form)
      if (success)
      {
        this.$router.push({ name: 'home' })
      }
    }
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
