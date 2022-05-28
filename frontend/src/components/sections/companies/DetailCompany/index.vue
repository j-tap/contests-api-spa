<template>
  <section>
    <Tabs v-model="currentTab">
      <TabsItem title="Розыгрыши">
        <div class="d-flex justify-content-end my-2">
          <Btn @click="onCreateContest">Создать</Btn>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <Card title="В работе:">
              <ContestsList :value="contestsInWork"/>
            </Card>
          </div>
          <div class="col-lg-6">
            <Card title="Архив:">
              <ContestsArchive :value="contestsArchive"/>
            </Card>
          </div>
        </div>
      </TabsItem>
      <TabsItem v-if="canAdmin" title="Менеджеры">
        <div class="row mt-2">
          <div class="col-lg-6">
            <Card>
              <ManagersList :value="value.users"/>
            </Card>
          </div>
        </div>
      </TabsItem>
      <TabsItem title="Настройки">
        <FormSettingFields
          :value="value.settings"
          @submit:form-settings="updateSettingsFields"
        />
      </TabsItem>
    </Tabs>
  </section>
</template>

<script>
import Card from '@/components/ui/Card'
import ContestsList from '@/components/sections/contests/ContestsList'
import ManagersList from '@/components/sections/users/ManagersList'
import Tabs from '@/components/ui/Tabs'
import TabsItem from '@/components/ui/Tabs/TabsItem'
import ContestsArchive from '@/components/sections/contests/ContestsArchive'
import Btn from '@/components/ui/Btn'
import FormSettingFields from '@/components/sections/settings/FormSettingFields';

export default {
  name: 'DetailCompany',

  components: {
    Card,
    ContestsList,
    ManagersList,
    Tabs,
    TabsItem,
    ContestsArchive,
    Btn,
    FormSettingFields,
  },

  props: {
    value: {
      type: Object,
      default: () => {},
    },
  },

  data() {
    return {
      currentTab: 0,
      currentAccordion: [1],
    }
  },

  computed: {
    contestsAll ()
    {
      return this.value.contests || []
    },
    contestsInWork ()
    {
      return this.contestsAll.filter(o => o.status && o.status.id === 1)
    },
    contestsArchive ()
    {
      return this.value.contestsArchive || {}
    },
  },

  methods: {
    onCreateContest ()
    {
      this.$emit('click:create-contest')
    },

    updateSettingsFields (form)
    {
      this.$emit(`submit:form-company-settings`, form)
    },
  },
}
</script>
