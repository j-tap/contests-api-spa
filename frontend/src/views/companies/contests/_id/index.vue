<template>
  <LayoutApp>
    <PageHeader>
      <template v-slot:title>
        <span>{{ pageTitle }}</span>
        <span class="fs-5 ms-2">
          <span v-if="contest.active" class="badge bg-success">Активен</span>
          <span v-else class="badge bg-secondary">Не активен</span>
        </span>
      </template>
      <template v-slot:right>
        <Btn v-if="isActive" color="info" @click="onQr">QR</Btn>
        <Btn v-if="isRandom" color="info" @click="onRandom">Розыгрыш</Btn>
        <div class="btn-group ms-3" role="group">
          <Btn @click="modalUpdateContest.show()">Изменить</Btn>
          <Btn v-if="canAdmin" color="secondary" @click="modalContestDeleteConfirm.show()">Удалить</Btn>
        </div>
      </template>
    </PageHeader>

    <DetailContest
      :value="contest"
      :careers="careers"
      @click:export-csv="exportParticipantsCsv"
      @submit:form-contest-settings="settingsUpdate"
      @submit:form-contest-paticipant="updateParticipant"
    />

    <Modal
      v-model="modalUpdateContest.display"
      :title="modalUpdateContest.title"
    >
      <FormContest
        ref="formContest"
        v-model="modalUpdateContest.form.data"
        :errors="modalUpdateContest.form.errors"
        :landingTemplates="landingTemplates"
        :statuses="statuses"
        @submit:form-contest="updateContest"
      />
    </Modal>

    <ModalConfirm
      v-model="modalContestDeleteConfirm.display"
      :title="modalContestDeleteConfirm.title"
      :action="deleteContest"
      :buttons="modalContestDeleteConfirm.buttons"
    />

  </LayoutApp>
</template>

<script>
import serviceContests from '@/services/contests'

import LayoutApp from '@/layouts/LayoutApp'
import PageHeader from '@/components/blocks/PageHeader'
import DetailContest from '@/components/sections/contests/DetailContest'
import Btn from '@/components/ui/Btn'
import Modal from '@/components/ui/Modal'
import ModalConfirm from '@/components/ui/ModalConfirm'
import FormContest from '@/components/sections/contests/FormContest'

export default {
  name: 'Contest',

  components: {
    LayoutApp,
    PageHeader,
    DetailContest,
    Btn,
    Modal,
    ModalConfirm,
    FormContest,
  },

  data ()
  {
    return {
      landingTemplates: [],
      careers: [],
      statuses: [],
      modalUpdateContest: {
        display: false,
        title: 'Редактирование розыгрыша',
        form: {
          errors: [],
          data: {},
        },
        show (display = true)
        {
          this.display = display
        },
      },
      modalContestDeleteConfirm: {
        display: false,
        title: 'Подтвердить удаление розыгрыша?',
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
    isActive ()
    {
      return !!this.contest.active
    },

    isRandom ()
    {
      return !this.isActive && this.contest.status && this.contest.status.id === 1
    },

    contest ()
    {
      return serviceContests.getContest()
    },

    pageTitle ()
    {
      if (this.contest.id)
      {
        const { name, company: { name: companyName } } = this.contest
        return `Розыгрыш ${name} компании ${companyName}`
      }
      return null
    },
  },

  watch: {
    contest: {
      handler (value)
      {
        const data = {}
        Object.keys(this.modalUpdateContest.form.data)
          .forEach(k =>
          {
            const obj = {}
            switch (k)
            {
              case 'landing_template_id':
                obj.value = value.landing_template?.id
                break
              case 'status_id':
                obj.value = value.status?.id
                break
              case 'date_from':
                obj.value = value.date?.from
                break
              case 'date_to':
                obj.value = value.date?.to
                break
              default:
                obj.value = value[k]
            }
            data[k] = obj
          })

        this.modalUpdateContest.form.data = data
      },
      immediate: true,
    }
  },

  created ()
  {
    this.getContest()
    this.getLandingTemplates()
    this.getCareers()
    this.getStatuses()
  },

  methods: {
    async getContest ()
    {
      const { id_contest } = this.$route.params
      await serviceContests.fetchItem(id_contest)
    },

    async getLandingTemplates ()
    {
      this.landingTemplates = await serviceContests.fetchLandingTemplates()
    },
    async getStatuses ()
    {
      this.statuses = await serviceContests.fetchStatuses()
    },
    async getCareers ()
    {
      this.careers = await serviceContests.fetchCareers()
    },

    async updateContest (form)
    {
      const { success, errors } = await serviceContests.updateItem(this.contest.id, form)
      this.modalUpdateContest.form.errors = errors

      if (success)
      {
        this.modalUpdateContest.show(false)
      }
    },

    async deleteContest ()
    {
      const { success } = await serviceContests.deleteItem(this.contest.id)

      if (success)
      {
        const { id_company } = this.$route.params
        this.modalContestDeleteConfirm.show(false)
        this.$router.push({ name: 'company', params: { id_company } })
      }
    },

    async settingsUpdate (form)
    {
      await serviceContests.settingsUpdate(form)
    },

    async updateParticipant ({ id, form })
    {
      await serviceContests.updateParticipant(id, form)
    },

    onQr ()
    {
      this.$router.push({ name: 'qr' })
    },

    onRandom ()
    {
      this.$router.push({ name: 'random' })
    },

    exportParticipantsCsv (data)
    {
      serviceContests.exportCsv(data)
    },
  },
}
</script>
