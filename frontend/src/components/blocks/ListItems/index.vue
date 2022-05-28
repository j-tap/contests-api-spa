<template>
  <ol class="list-items list-group list-group-numbered">
    <li
      v-for="(item, i) in value"
      :key="`item-${i}`"
      class="list-items__item list-group-item"
    >
      <div class="d-flex justify-content-between">
        <div>
          <slot name="item" :item="item">
            <div class="mb-2">
              <span class="fw-bold">{{ item.name }}</span>&nbsp;
            </div>
          </slot>
        </div>
        <div class="list-items__actions">
          <div class="btn-group" role="group">
            <Btn size="sm" @click="update(item)">Изменить</Btn>
            <Btn v-if="displayDelete" size="sm" color="secondary" @click="remove(item)">Удалить</Btn>
          </div>
        </div>
      </div>
    </li>
     <li v-if="!value.length">Записей нет</li>
  </ol>
</template>

<script>
import Btn from '@/components/ui/Btn'

export default {
	name: 'ListItems',

  components: {
    Btn,
  },

  props: {
    value: {
      type: Array,
      default: () => [],
    },
    displayDelete: {
      type: Boolean,
      default: true,
    },
  },

  methods: {
    update (item)
    {
      this.$emit('update-item', item)
    },
    remove (item)
    {
      this.$emit('delete-item', item)
    },
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
