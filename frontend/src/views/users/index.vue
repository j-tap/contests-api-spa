<template>
  <LayoutApp>
    <PageHeader>
      <template v-slot:title>{{ pageTitle }}</template>
      <template v-slot:right>
        <Btn @click="modalCreateUser.show()">Создать</Btn>
      </template>
    </PageHeader>

    <Table :value="usersTable"/>

    <Modal
      v-model="modalCreateUser.display"
      :title="modalCreateUser.title"
    >
      <FormUser
        ref="formUser"
        :errors="modalCreateUser.errors"
        :companies="companies"
        :roles="roles"
        @submit:form-user="createUser"
      />
    </Modal>
  </LayoutApp>
</template>

<script>
import serviceUsers from '@/services/users'

import LayoutApp from '@/layouts/LayoutApp'
import PageHeader from '@/components/blocks/PageHeader'
import Btn from '@/components/ui/Btn'
import Table from '@/components/ui/Table'
import Modal from '@/components/ui/Modal'
import FormUser from '@/components/sections/users/FormUser'

export default {
  name: 'Users',

  components: {
    LayoutApp,
    PageHeader,
    Btn,
    Table,
    Modal,
    FormUser,
  },

  data() {
    return {
      pageTitle: 'Пользователи системы',
      companies: [],
      roles: [],
      modalCreateUser: {
        display: false,
        title: 'Добавление нового пользователя',
        errors: [],
        show (display = true)
        {
          this.display = display
        },
      },
    }
  },

  computed: {
    usersTable ()
    {
      return serviceUsers.getTable()
    },
  },

  created ()
  {
    this.getUsers()
    this.getCompanies()
    this.getRoles()
  },

  methods: {
    async getUsers ()
    {
      await serviceUsers.fetchAll()
    },

    async createUser (form)
    {
      const { success, errors } = await serviceUsers.createItem(form)
      this.modalCreateUser.errors = errors

      if (success)
      {
        this.modalCreateUser.show(false)
        this.$refs.formUser.clearForm()
      }
    },

    async getCompanies ()
    {
      this.companies = await serviceUsers.getCompanies()
    },

    async getRoles ()
    {
      this.roles = await serviceUsers.getRoles()
    },

  },
}
</script>
