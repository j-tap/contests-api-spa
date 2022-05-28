<template>
  <LayoutApp>
    <PageHeader>
      <template v-slot:title>Компания {{ company.name }}</template>
      <template v-slot:right>
        <div class="btn-group" role="group">
          <Btn v-if="canAdmin" @click="modalUpdateCompany.show()">Изменить</Btn>
          <Btn v-if="canAdmin" color="secondary" @click="modalCompanyDeleteConfirm.show()">Удалить</Btn>
        </div>
      </template>
    </PageHeader>

    <DetailCompany
      :value="company"
      @click:create-contest="modalCreateContest.show()"
      @submit:form-company-settings="settingsUpdate"
    />

    <Modal
      v-model="modalUpdateCompany.display"
      :title="modalUpdateCompany.title"
    >
      <FormCompany
        ref="formCompany"
        v-model="modalUpdateCompany.form.data"
        :errors="modalUpdateCompany.form.errors"
        @submit:form-company="updateCompany"
      />
    </Modal>

    <ModalConfirm
      v-model="modalCompanyDeleteConfirm.display"
      :title="modalCompanyDeleteConfirm.title"
      :action="deleteCompany"
      :buttons="modalCompanyDeleteConfirm.buttons"
    />

    <Modal
      v-model="modalCreateContest.display"
      :title="modalCreateContest.title"
    >
      <FormContest
        ref="formContest"
        :errors="modalCreateContest.form.errors"
        :landingTemplates="landingTemplates"
        :statuses="statuses"
        @submit:form-contest="createContest"
      />
    </Modal>
  </LayoutApp>
</template>

<script>
import serviceCompanies from '@/services/companies'

import LayoutApp from '@/layouts/LayoutApp'
import PageHeader from '@/components/blocks/PageHeader'
import DetailCompany from '@/components/sections/companies/DetailCompany'
import Btn from '@/components/ui/Btn'
import Modal from '@/components/ui/Modal'
import ModalConfirm from '@/components/ui/ModalConfirm'
import FormContest from '@/components/sections/contests/FormContest'
import FormCompany from '@/components/sections/companies/FormCompany'

export default {
  name: 'Company',

  components: {
    LayoutApp,
    PageHeader,
    DetailCompany,
    Btn,
    Modal,
    ModalConfirm,
    FormContest,
    FormCompany,
  },

  data () {
    return {
      landingTemplates: [],
      statuses: [],
      modalUpdateCompany: {
        display: false,
        title: 'Редактирование компании',
        form: {
          errors: [],
          data: {},
        },
        show (display = true)
        {
          this.display = display
        },
      },
      modalCompanyDeleteConfirm: {
        display: false,
        title: 'Подтвердить удаление компании?',
        buttons: {
          accept: { text: 'Удалить' },
        },
        show (display = true)
        {
          this.display = display
        },
      },
      modalCreateContest: {
        display: false,
        title: 'Создание нового розыгрыша',
        form: {
          errors: [],
        },
        show (display = true)
        {
          this.display = display
        },
      },
    }
  },

  computed: {
    company ()
    {
      return serviceCompanies.getCompany()
    },
  },

  watch: {
    company: {
      /* Установка значений */
      handler (value)
      {
        const data = {}
        Object.keys(this.modalUpdateCompany.form.data)
          .forEach(k => data[k] = { value: value[k] })
        this.modalUpdateCompany.form.data = data
      },
      immediate: true,
    }
  },

  created ()
  {
    this.getCompany()
    this.getLandingTemplates()
    this.getStatuses()
  },

  methods: {
    async getCompany ()
    {
      const { id_company } = this.$route.params
      await serviceCompanies.fetchItem(id_company)
    },

    async getLandingTemplates ()
    {
      this.landingTemplates = await serviceCompanies.fetchLandingTemplates()
    },

    async getStatuses ()
    {
      this.statuses = await serviceCompanies.fetchStatuses()
    },

    async updateCompany (form)
    {
      const { success, errors } = await serviceCompanies.updateItem(this.company.id, form)
      this.modalUpdateCompany.form.errors = errors

      if (success)
      {
        this.modalUpdateCompany.show(false)
      }
    },

    async deleteCompany ()
    {
      const { success } = await serviceCompanies.deleteItem(this.company.id)

      if (success)
      {
        this.modalCompanyDeleteConfirm.show(false)
        this.$router.push({ name: 'home' })
      }
    },

    async createContest (form)
    {
      Object.assign(form, { company_id: { value: this.company.id }})
      const { success, errors } = await serviceCompanies.createContest(form)
      this.modalCreateContest.form.errors = errors

      if (success)
      {
        this.modalCreateContest.show(false)
        this.$refs.formContest.clearForm()
      }
    },

    async settingsUpdate (form)
    {
      await serviceCompanies.settingsUpdate(form)
    },

  },
}
</script>
