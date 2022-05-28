<template>
  <div>
    <div class="d-flex justify-content-end mb-3">
      <Btn @click="modalCreateTemplate.show()">Создать</Btn>
    </div>

    <ListItems
      :value="templates"
      @update-item="showUpdateTemplate"
      @delete-item="modalTemplateDeleteConfirm.show({ item: $event })"
    >
      <template v-slot:item="{ item }">
        <div class="mb-2">
          <span class="fw-bold">{{ item.name }}</span>&nbsp;
          <code>{{ item.key }}</code>
        </div>
      </template>
    </ListItems>

    <Modal
      v-model="modalCreateTemplate.display"
      :title="modalCreateTemplate.title"
    >
      <FormTemplate
        ref="formCreateTemplate"
        v-model="modalCreateTemplate.form.data"
        :errors="modalCreateTemplate.form.errors"
        @submit:form-template="createTemplate"
      />
    </Modal>

    <Modal
      v-model="modalUpdateTemplate.display"
      :title="modalUpdateTemplate.title"
    >
      <FormTemplate
        ref="formUpdateTemplate"
        v-model="modalUpdateTemplate.form.data"
        :errors="modalUpdateTemplate.form.errors"
        @submit:form-template="updateTemplate"
      />
    </Modal>

    <ModalConfirm
      v-model="modalTemplateDeleteConfirm.display"
      :title="modalTemplateDeleteConfirm.title"
      :action="() => deleteTemplate(modalTemplateDeleteConfirm.item)"
      :buttons="modalTemplateDeleteConfirm.buttons"
    />
  </div>
</template>

<script>
import serviceTemplates from '@/services/templates'

import Btn from '@/components/ui/Btn'
import Modal from '@/components/ui/Modal'
import FormTemplate from '@/components/sections/templates/FormTemplate'
import ListItems from '@/components/blocks/ListItems'
import ModalConfirm from '@/components/ui/ModalConfirm'

export default {
  name: 'TemplatesMain',

  components: {
    Btn,
    Modal,
    FormTemplate,
    ListItems,
    ModalConfirm,
  },

  data() {
    return {
      modalCreateTemplate: {
        display: false,
        title: 'Добавление Шаблона',
        form: {
          data: {},
          errors: [],
        },
        show (display = true)
        {
          this.display = display
        },
      },
      modalUpdateTemplate: {
        display: false,
        title: 'Редактирование Шаблона',
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
              obj.value = item[k]
              data[k] = obj
            })

          this.form.data = data
          this.item = item
          this.display = display
        },
      },
      modalTemplateDeleteConfirm: {
        display: false,
        title: null,
        item: {},
        buttons: {
          accept: { text: 'Удалить' },
        },
        show ({ display = true, item = {} })
        {
          this.item = item
          this.title = `Подтвердить удаление шаблона ${this.item.name}?`,
          this.display = display
        },
      },
    }
  },

  computed: {
    templates ()
    {
      return serviceTemplates.getTemplates()
    },
  },

  created ()
  {
    this.getTemplates()
  },

  methods: {
    async getTemplates ()
    {
      await serviceTemplates.fetchAll()
    },

    async createTemplate (form)
    {
      const { success, errors } = await serviceTemplates.createItem(form)
      this.modalCreateTemplate.form.errors = errors

      if (success)
      {
        this.modalCreateTemplate.show(false)
        this.$refs.formCreateTemplate.clearForm()
      }
    },

    async updateTemplate (form)
    {
      const { id } = this.modalUpdateTemplate.item
      const { success, errors } = await serviceTemplates.updateItem(id, form)
      this.modalUpdateTemplate.form.errors = errors

      if (success)
      {
        this.modalUpdateTemplate.show({ display: false })
        this.$refs.formUpdateTemplate.clearForm()
      }
    },

    showUpdateTemplate (item)
    {
      this.modalUpdateTemplate.show({ item, display: true })
    },

    async deleteTemplate (data)
    {
      const { success } = await serviceTemplates.deleteItem(data.id)
      if (success)
      {
        this.modalTemplateDeleteConfirm.show({ display: false })
      }
    },

  },
}
</script>
