<template>
  <LayoutApp>
    <PageHeader>
      <template v-slot:title>{{ pageTitle }}</template>
    </PageHeader>

    <Tabs v-model="currentTab">
      <TabsItem title="Лог">
        <Table :value="log"/>
      </TabsItem>
      <TabsItem title="Управление">
        <TgUInfo
          :data="tg.data"
          @submit:tg-auth="tgAuth"
          @submit:tg-logout="tgLogout"
        />
      </TabsItem>
    </Tabs>

  </LayoutApp>
</template>

<script>
import serviceSystem from '@/services/system'

import LayoutApp from '@/layouts/LayoutApp'
import PageHeader from '@/components/blocks/PageHeader'
import Table from '@/components/ui/Table'
import Tabs from '@/components/ui/Tabs'
import TabsItem from '@/components/ui/Tabs/TabsItem'
import TgUInfo from '@/components/sections/system/TgUInfo'


export default {
  name: 'System',

  components: {
    LayoutApp,
    PageHeader,
    Table,
    Tabs,
    TabsItem,
    TgUInfo,
  },

  data() {
    return {
      currentTab: 0,
      pageTitle: 'Система',
      log: [],
      tg: {
        data: {},
      },
    }
  },

  created ()
  {
    this.getTgStatus()
    this.getLog()
  },

  methods: {
    async getLog ()
    {
      this.log = await serviceSystem.getLog()
    },

    async getTgStatus ()
    {
      this.tg.data = await serviceSystem.getTgStatus()
    },

    async tgAuth (data)
    {
      const { success } = await serviceSystem.tgAuth(data)
      if (success && data)
      {
        await this.getTgStatus()
      }
    },

    async tgLogout ()
    {
      const success = await serviceSystem.tgLogout()
      if (success)
      {
        await this.getTgStatus()
      }
    },

  },
}
</script>
