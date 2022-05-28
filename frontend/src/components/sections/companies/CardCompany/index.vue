<template>
  <Card
    class="card-company"
    :to="{ name: 'company', params: { id_company: value.id } }"
  >
    <h5 class="card-title">{{ value.name }}</h5>
    <template v-slot:footer>
      <span class="text-muted" title="активные / все">
        <span class="pe-2">Розыгрыши:</span>
        <span class="text-success">{{ value.contests_count.active }}</span>
        &nbsp;/&nbsp;
        <span>{{ value.contests_count.all }}</span>
      </span>
    </template>
  </Card>
</template>

<script>
import Card from '@/components/ui/Card'

export default {
	name: 'CardCompany',

  components: {
    Card,
	},

  props: {
    value: {
      type: Object,
      default: () => ({}),
    },
  },

}
</script>

<style scoped lang="scss" src="./style.scss"></style>
