<template>
  <LayoutApp>
    <PageHeader>
      <template v-slot:title>{{ pageTitle }}</template>
      <template v-slot:right>
        <div class="btn-group" role="group">
          <Btn v-if="canAdmin" @click="modalCreateCompany.show()">Создать</Btn>
        </div>
      </template>
    </PageHeader>

    <div class="row">
      <div
        v-for="(company, i) in companies"
        :key="`company-${i}`"
        class="col-md-6 col-lg-4 mb-3"
      >
        <CardCompany :value="company"/>
      </div>
    </div>

    <Modal
      v-model="modalCreateCompany.display"
      :title="modalCreateCompany.title"
    >
      <FormCompany
        ref="formCreateCompany"
        :errors="modalCreateCompany.errors"
        @submit:form-company="createCompany"
      />
    </Modal>
  </LayoutApp>
</template>

<script>
import serviceCompanies from '@/services/companies'

import LayoutApp from '@/layouts/LayoutApp'
import PageHeader from '@/components/blocks/PageHeader'
import CardCompany from '@/components/sections/companies/CardCompany'
import Btn from '@/components/ui/Btn'
import Modal from '@/components/ui/Modal'
import FormCompany from '@/components/sections/companies/FormCompany'

export default {
  name: 'Home',

  components: {
    LayoutApp,
    PageHeader,
    CardCompany,
    Btn,
    Modal,
    FormCompany,
  },

  data ()
  {
    return {
      pageTitle: 'Компании',
      modalCreateCompany: {
        display: false,
        title: 'Создание новой компании',
        errors: [],
        show (display = true)
        {
          this.display = display
        },
      },
    }
  },

  computed: {
    companies ()
    {
      return serviceCompanies.getCompanies()
    }
  },

  created ()
  {
    this.getCompanies()
  },

  methods: {
    async getCompanies ()
    {
      await serviceCompanies.fetchAll()
    },

    async createCompany (form)
    {
      const { success, errors } = await serviceCompanies.createItem(form)
      this.modalCreateCompany.errors = errors

      if (success)
      {
        this.modalCreateCompany.show(false)
        this.$refs.formCreateCompany.clearForm()
      }
    },
  },
}
</script>
