<template>
  <div>
    <div class="d-flex justify-content-end mb-3">
      <Btn @click="modalCreateCareer.show()">Создать</Btn>
    </div>

    <ListItems
      :value="careers"
      @update-item="showUpdateCareer"
      @delete-item="modalCareerDeleteConfirm.show({ item: $event })"
    />

    <Modal
      v-model="modalCreateCareer.display"
      :title="modalCreateCareer.title"
    >
      <FormCareer
        ref="formCreateCareer"
        v-model="modalCreateCareer.form.data"
        :errors="modalCreateCareer.form.errors"
        @submit:form-career="createCareer"
      />
    </Modal>

    <Modal
      v-model="modalUpdateCareer.display"
      :title="modalUpdateCareer.title"
    >
      <FormCareer
        ref="formUpdateCareer"
        v-model="modalUpdateCareer.form.data"
        :errors="modalUpdateCareer.form.errors"
        @submit:form-career="updateCareer"
      />
    </Modal>

    <ModalConfirm
      v-model="modalCareerDeleteConfirm.display"
      :title="modalCareerDeleteConfirm.title"
      :action="() => deleteCareer(modalCareerDeleteConfirm.item)"
      :buttons="modalCareerDeleteConfirm.buttons"
    />
  </div>
</template>

<script>
import serviceCareers from '@/services/careers'

import Btn from '@/components/ui/Btn'
import Modal from '@/components/ui/Modal'
import FormCareer from '@/components/sections/careers/FormCareer'
import ListItems from '@/components/blocks/ListItems'
import ModalConfirm from '@/components/ui/ModalConfirm'

export default {
  name: 'CareersMain',

  components: {
    Btn,
    Modal,
    FormCareer,
    ListItems,
    ModalConfirm,
  },

  data() {
    return {
      modalCreateCareer: {
        display: false,
        title: 'Добавление Вида деятельности',
        form: {
          data: {},
          errors: [],
        },
        show (display = true)
        {
          this.display = display
        },
      },
      modalUpdateCareer: {
        display: false,
        title: 'Редактирование Вида деятельности',
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
      modalCareerDeleteConfirm: {
        display: false,
        title: null,
        item: {},
        buttons: {
          accept: { text: 'Удалить' },
        },
        show ({ display = true, item = {} })
        {
          this.item = item
          this.title = `Подтвердить удаление деятельности ${this.item.name}?`,
          this.display = display
        },
      },

    }
  },

  computed: {
    careers ()
    {
      return serviceCareers.getCareers()
    },
  },

  created ()
  {
    this.getCareers()
  },

  methods: {
    async getCareers ()
    {
      await serviceCareers.fetchAll()
    },

    async createCareer (form)
    {
      const { success, errors } = await serviceCareers.createItem(form)
      this.modalCreateCareer.form.errors = errors

      if (success)
      {
        this.modalCreateCareer.show(false)
        this.$refs.formCreateCareer.clearForm()
      }
    },

    async updateCareer (form)
    {
      const { id } = this.modalUpdateCareer.item
      const { success, errors } = await serviceCareers.updateItem(id, form)
      this.modalUpdateCareer.form.errors = errors

      if (success)
      {
        this.modalUpdateCareer.show({ display: false })
        this.$refs.formUpdateCareer.clearForm()
      }
    },

    showUpdateCareer (item)
    {
      this.modalUpdateCareer.show({ item, display: true })
    },

    async deleteCareer (data)
    {
      const { success } = await serviceCareers.deleteItem(data.id)

      if (success)
      {
        this.modalCareerDeleteConfirm.show({ display: false })
      }
    },

  },
}
</script>
