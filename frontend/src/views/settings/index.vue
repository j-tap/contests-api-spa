<template>
  <LayoutApp>
    <PageHeader>
      <template v-slot:title>{{ pageTitle }}</template>
    </PageHeader>

    <Tabs v-model="currentTab" class="mb-5">
      <TabsItem v-if="canAdmin" title="Основные">
        <SettingsMain/>
      </TabsItem>
      <TabsItem v-if="canAdmin" title="Шаблоны">
        <TemplatesMain/>
      </TabsItem>
      <TabsItem title="Виды деятельности">
        <CareersMain/>
      </TabsItem>
    </Tabs>

  </LayoutApp>
</template>

<script>
import LayoutApp from '@/layouts/LayoutApp'
import PageHeader from '@/components/blocks/PageHeader'
import CareersMain from '@/components/sections/careers/CareersMain'
import SettingsMain from '@/components/sections/settings/SettingsMain'
import TemplatesMain from '@/components/sections/templates/TemplatesMain'
import Tabs from '@/components/ui/Tabs'
import TabsItem from '@/components/ui/Tabs/TabsItem'

export default {
  name: 'Settings',

  components: {
    LayoutApp,
    PageHeader,
    CareersMain,
    SettingsMain,
    TemplatesMain,
    Tabs,
    TabsItem
  },

  data() {
    return {
      pageTitle: 'Настройки',
      currentTab: 0,
    }
  },

  computed: {
    canAdmin()
    {
      return this.$store.getters['auth/canAdmin']
    },
  },
}
</script>
