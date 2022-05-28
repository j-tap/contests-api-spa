<template>
  <div>
    <div class="d-flex justify-content-end mb-3">
      <Btn @click="modalCreateSetting.show()">Создать</Btn>
    </div>
    <ListSettings
      :value="settings"
      @update-item-settings="showUpdateSetting"
    />

    <Modal
      v-model="modalCreateSetting.display"
      :title="modalCreateSetting.title"
    >
      <FormSetting
        ref="formCreateSetting"
        v-model="modalCreateSetting.form.data"
        :errors="modalCreateSetting.form.errors"
        :settingsTypes="settingsTypes"
        :companies="companies"
        :contests="contests"
        @submit:form-setting="createSetting"
      />
    </Modal>

    <Modal
      v-model="modalUpdateSetting.display"
      :title="modalUpdateSetting.title"
    >
      <FormSetting
        ref="formUpdateSetting"
        v-model="modalUpdateSetting.form.data"
        :errors="modalUpdateSetting.form.errors"
        :settingsTypes="settingsTypes"
        :companies="companies"
        :contests="contests"
        edit
        @submit:form-setting="updateSetting"
      />
    </Modal>
  </div>
</template>

<script>
import serviceSettings from '@/services/settings'

import Btn from '@/components/ui/Btn'
import Modal from '@/components/ui/Modal'
import FormSetting from '@/components/sections/settings/FormSetting'
import ListSettings from '@/components/sections/settings/ListSettings'

export default {
  name: 'SettingsMain',

  components: {
    Btn,
    Modal,
    FormSetting,
    ListSettings,
  },

  data() {
    return {
      pageTitle: 'Настройки',
      settingsTypes: [],
      companies: [],
      contests: [],
      modalCreateSetting: {
        display: false,
        title: 'Добавление новой настройки',
        form: {
          data: {},
          errors: [],
        },
        show (display = true)
        {
          this.display = display
        },
      },
      modalUpdateSetting: {
        display: false,
        title: null,
        item: {},
        form: {
          data: {},
          errors: [],
        },
        show ({ display = true, item = {} })
        {
          const data = {}
          Object.keys(this.form.data)
            .forEach(k =>
            {
              const obj = {}
              switch (k)
              {
                case 'setting_type_id':
                  obj.value = item.setting_type?.id
                  break
                case 'company_id':
                  obj.value = item.contest ? item.contest?.company.id : item.company?.id
                  break
                case 'contest_id':
                  obj.value = item.contest?.id
                  break
                default:
                  obj.value = item[k]
              }
              data[k] = obj
            })

          this.form.data = data
          this.item = item
          this.title = `Редактирование настройки: ${item.name}`
          this.display = display
        },
      },
      currentTab: 0,
    }
  },

  computed: {
    settings ()
    {
      return serviceSettings.getSettings()
    },
  },

  created ()
  {
    this.getSettings()
    this.getSettingsTypes()
    this.getCompanies()
    this.getContests()
  },

  methods: {
    async getSettings ()
    {
      await serviceSettings.fetchAll()
    },
    async getSettingsTypes ()
    {
      this.settingsTypes = await serviceSettings.fetchSettingsTypes()
    },
    async getCompanies ()
    {
      this.companies = await serviceSettings.fetchCompanies()
    },
    async getContests ()
    {
      this.contests = await serviceSettings.fetchContests()
    },

    async createSetting (form)
    {
      const { success, errors } = await serviceSettings.createItem(form)
      this.modalCreateSetting.form.errors = errors

      if (success)
      {
        this.modalCreateSetting.show(false)
        this.$refs.formCreateSetting.clearForm()
      }
    },

    async updateSetting (form)
    {
      const { id } = this.modalUpdateSetting.item
      const { success, errors } = await serviceSettings.updateItem(id, form)
      this.modalUpdateSetting.form.errors = errors

      if (success)
      {
        this.modalUpdateSetting.show({ display: false })
        this.$refs.formUpdateSetting.clearForm()
      }
    },

    showUpdateSetting (data)
    {
      this.modalUpdateSetting.show(data)
    }

  },
}
</script>
