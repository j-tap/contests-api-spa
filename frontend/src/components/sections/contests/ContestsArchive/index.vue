<template>
  <Accordion v-if="Object.keys(value).length">
    <AccordionItem
      v-for="(groupYear, year) in value"
      :key="`group-${year}`"
      :title="groupYear.title"
    >
      <Accordion>
        <AccordionItem
          v-for="(groupMonth, month) in groupYear.list"
          :key="`group-${month}`"
          :title="groupMonth.title"
        >
          <ContestsList :value="groupMonth.list"/>
        </AccordionItem>
      </Accordion>
    </AccordionItem>
  </Accordion>
  <div v-else>Нет розыгрышей</div>
</template>

<script>
import Accordion from '@/components/ui/Accordion'
import AccordionItem from '@/components/ui/Accordion/AccordionItem'
import ContestsList from '@/components/sections/contests/ContestsList'

export default {
  name: 'ContestsArchive',

  components: {
    Accordion,
    AccordionItem,
    ContestsList,
  },

  props: {
    value: {
      type: Object,
      default: () => ({}),
    },
  },
}
</script>
