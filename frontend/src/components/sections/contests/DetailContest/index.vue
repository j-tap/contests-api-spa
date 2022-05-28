<template>
  <Tabs v-model="currentTab">
    <TabsItem title="Участники">
      <TableWithFilter
        :value="participants"
        :careers="careers"
        @click:table-export-csv="onClickToCsv"
        @click:table-export-code="onClickCodes"
        @submit:table-form-contest-paticipant="updateParticipant"
      />
    </TabsItem>
    <TabsItem title="Статистика">
      <dl class="row">
        <dt class="col-sm-3">Статус</dt>
        <dd class="col-sm-9">{{ value.status?.name }}</dd>
        <dt class="col-sm-3">Время проведения</dt>
        <dd class="col-sm-9">
          <span v-if="value.date && value.date.from">{{ value.date.from_visual }} - {{ value.date.to_visual }}</span>
        </dd>
        <dt class="col-sm-3">Шаблон</dt>
        <dd class="col-sm-9">{{ value.landing_template?.name }}</dd>
        <dt class="col-sm-3">Сгенерировано приглашений</dt>
        <dd class="col-sm-9">{{ invitesCount }}</dd>
        <dt class="col-sm-3">Зарегистрировано участников</dt>
        <dd class="col-sm-9">{{ acceptedInvites }}</dd>
      </dl>
    </TabsItem>
    <TabsItem title="Настройки">
      <FormSettingFields
        :value="value.settings"
        @submit:form-settings="updateSettingsFields"
      />
    </TabsItem>
  </Tabs>

  <Modal
    v-model="modalCodes.display"
    :title="modalCodes.title"
  >
    <textarea :value="modalCodes.content" class="form-control w-100" rows="10" readonly></textarea>
  </Modal>
</template>

<script>
import TableWithFilter from './TableWithFilter'
import Modal from '@/components/ui/Modal'
import Tabs from '@/components/ui/Tabs'
import TabsItem from '@/components/ui/Tabs/TabsItem'
import FormSettingFields from '@/components/sections/settings/FormSettingFields';

export default {
  name: 'DetailContest',

  components: {
    TableWithFilter,
    Modal,
    Tabs,
    TabsItem,
    FormSettingFields,
  },

  props: {
    value: {
      type: Object,
      default: () => ({}),
    },
    careers: {
      type: Array,
      default: () => [],
    },
  },

  emits: [
    'click:export-csv',
    'submit:form-contest-settings',
    'submit:form-contest-paticipant',
  ],

  data() {
    return {
      currentTab: 0,
      modalCodes: {
        display: false,
        title: 'Коды участников',
        content: '',
        show (display = true)
        {
          this.display = display
        },
      },
    }
  },

  computed: {
    invitesCount ()
    {
      return this.value?.invites ? this.value.invites.length : 0
    },

    acceptedInvites ()
    {
      return this.value?.invites ? this.value.invites.filter(o => o.user).length : 0
    },

    participants ()
    {
      const { participants } = this.value
      return participants || {}
    },
  },

  methods: {
    onClickCodes (data)
    {
      this.modalCodes.content = data.join(', ')
      this.modalCodes.show()
    },

    onClickToCsv (data)
    {
      this.$emit('click:export-csv', data)
    },

    updateSettingsFields (form)
    {
      this.$emit('submit:form-contest-settings', form)
    },

    async updateParticipant (data)
    {
      this.$emit('submit:form-contest-paticipant', data)
    },
  },
}
</script>
