<template>
  <ListItems
    :value="settings"
    :display-delete="false"
    @update-item="updateItem"
  >
    <template v-slot:item="{ item }">
      <div class="mb-2">
        <span class="fw-bold">{{ item.name }}</span>&nbsp;
        <code>{{ item.key }}</code>:&nbsp;
        <span class="h5">
          <span class="badge bg-info">{{ item.value }}</span>
        </span>
      </div>
      <div class="small">{{ item.description }}</div>
      <div class="small">{{ item.type?.description }}</div>
      <div class="d-flex">
        <span v-if="item.company" class="small">Компания: {{ item.company.name }}</span>
        <span v-if="item.contest" class="small">Розыгрыш: {{ item.contest.name }}</span>
      </div>
    </template>
  </ListItems>
</template>

<script>
import ListItems from '@/components/blocks/ListItems'

export default {
	name: 'ListSettings',

  components: {
    ListItems,
  },

  props: {
    value: {
      type: Array,
      default: () => [],
    },
  },

  data() {
    return {}
  },

  computed: {
    settings ()
    {
      return this.value.map(o =>
      {
        return {
          ...o,
          value: o.value || 'null',
        }
      })
    },
  },

  methods: {
    updateItem (item)
    {
      this.$emit('update-item-settings', { item, display: true })
    },
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
