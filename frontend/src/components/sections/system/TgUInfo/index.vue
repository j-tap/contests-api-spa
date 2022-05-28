<template>
  <Card title="Интеграция Telegram">
    <div class="row">
      <div class="col-md-6 col-lg-6 col-xl-4">
        <dl class="row">
          <dt class="col-sm-6">Авторизация</dt>
          <dd class="col-sm-6">
            <span v-if="data.is_logged" class="text-success">Да</span>
            <span v-else class="text-warning">Нет</span>
          </dd>
          <dt class="col-sm-6">Ключ настройки телефона</dt>
          <dd class="col-sm-6">
            <code>{{ data.setting_key }}</code>
          </dd>
          <dt class="col-sm-6">Телефон привязки</dt>
          <dd class="col-sm-6">{{ data.phone }}</dd>
        </dl>
      </div>
      <div class="col-md-4 col-lg-3 col-xl-2">
        <Btn v-if="data.is_logged" @click="tgLogout">Отвязаться</Btn>
        <template v-else>
          <Btn v-if="data.phone" class="mb-2" @click="tgAuth()">Отправить код</Btn>
          <div v-else class="alert alert-warning">Необходимо добавить телефон в настройки</div>
          <FormTgCode
            ref="formTgCode"
            v-model="tgCode.data"
            :errors="tgCode.errors"
            @submit:form-tgcode="tgAuth"
          />
        </template>
      </div>
    </div>
  </Card>
</template>

<script>
import FormTgCode from '@/components/sections/system/FormTgCode'
import Btn from '@/components/ui/Btn'
import Card from '@/components/ui/Card'

export default {
	name: 'TgUInfo',

  components: {
    FormTgCode,
		Btn,
    Card,
	},

  props: {
    data: {
      type: Object,
      default: () => ({}),
    },
  },

  data() {
    return {
      tgCode: {
        data: {},
        errors: {},
      },
    }
  },

  watch: {
    tgCode (data)
    {
      if (data.is_logged)
      {
        this.tgCode.data.code.value = null
      }
    },
  },

  methods: {
    tgAuth (form = null)
    {
      this.$emit('submit:tg-auth', form)
    },

    tgLogout ()
    {
      this.$emit('submit:tg-logout')
    },
  },

}
</script>
