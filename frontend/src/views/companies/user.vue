<template>
  <LayoutApp>
    <PageHeader>
      <template v-slot:title>Пользователь {{ user.name }}</template>
      <template v-slot:right>
        <div class="btn-group" role="group">
          <Btn @click="modalUpdateUser.show()">Изменить</Btn>
          <Btn color="secondary" @click="modalUserDeleteConfirm.show()">Удалить</Btn>
        </div>
      </template>
    </PageHeader>

    <DetailUser :value="user"/>

    <Modal
      v-model="modalUpdateUser.display"
      :title="modalUpdateUser.title"
    >
      <FormUser
        ref="formUser"
        v-model="modalUpdateUser.form.data"
        :errors="modalUpdateUser.errors"
        :companies="companies"
        :roles="roles"
        edit
        @submit:form-user="updateUser"
      />
    </Modal>

    <ModalConfirm
      v-model="modalUserDeleteConfirm.display"
      :title="modalUserDeleteConfirm.title"
      :action="deleteUser"
      :buttons="modalUserDeleteConfirm.buttons"
    />

  </LayoutApp>
</template>

<script>
import serviceUsers from '@/services/users'

import LayoutApp from '@/layouts/LayoutApp'
import PageHeader from '@/components/blocks/PageHeader'
import DetailUser from '@/components/sections/users/DetailUser'
import Modal from '@/components/ui/Modal'
import ModalConfirm from '@/components/ui/ModalConfirm'
import FormUser from '@/components/sections/users/FormUser'
import Btn from '@/components/ui/Btn'

export default {
  name: 'Contest',

  components: {
    LayoutApp,
    PageHeader,
    DetailUser,
    Modal,
    ModalConfirm,
    FormUser,
    Btn,
  },

  data ()
  {
    return {
      roles: [],
      companies: [],
      modalUpdateUser: {
        display: false,
        title: 'Редактирование менеджера',
        form: {
          errors: [],
          data: {},
        },
        show (display = true)
        {
          this.display = display
        },
      },
      modalUserDeleteConfirm: {
        display: false,
        title: 'Подтвердить удаление менеджера?',
        buttons: {
          accept: { text: 'Удалить' },
        },
        show (display = true)
        {
          this.display = display
        },
      },
    }
  },

  computed: {
    user ()
    {
      return serviceUsers.getUser()
    },
  },

  watch: {
    user: {
      /* Установка значений */
      handler (value)
      {
        const data = {}
        Object.keys(this.modalUpdateUser.form.data)
          .forEach(k =>
          {
            const obj = {}
            switch (k)
            {
              case 'companies':
                obj.value = value.companies.map(o => o.id)
                break
              case 'role_id':
                obj.value = value.role.id
                break
              default:
                obj.value = value[k]
            }
            data[k] = obj
          })
        this.modalUpdateUser.form.data = data
      },
      immediate: true,
    }
  },

  created ()
  {
    this.getUser()
    this.getCompanies()
    this.getRoles()
  },

  methods: {
    async getUser ()
    {
      const { id_user } = this.$route.params
      await serviceUsers.fetchItem(id_user)
    },

    async getCompanies ()
    {
      this.companies = await serviceUsers.getCompanies()
    },

    async getRoles ()
    {
      this.roles = await serviceUsers.getRoles()
    },

    async updateUser (form)
    {
      const { success, errors } = await serviceUsers.updateItem(this.user.id, form)
      this.modalUpdateUser.form.errors = errors

      if (success)
      {
        this.modalUpdateUser.show(false)
      }
    },

    async deleteUser ()
    {
      const { success } = await serviceUsers.deleteItem(this.user.id)

      if (success)
      {
        this.modalUserDeleteConfirm.show(false)
        this.$router.push({ name: 'company' })
      }
    },
  },
}
</script>
