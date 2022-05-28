<template>
  <div class="list-group">
    <template v-if="value.length">
      <router-link
        v-for="(contest, i) in value"
        :key="`contest-${i}`"
        class="list-group-item list-group-item-action"
        :to="{ name: 'contest', params: { id_contest: contest.id } }"
      >
        <div class="d-flex justify-content-between">
          <div class="ms-2 me-auto">
            <h3 class="h5">{{ contest.name }}</h3>
          </div>
          <div>
            <span v-if="contest.active" class="badge bg-success">Активен</span>
            <span v-else class="badge bg-secondary">Не активен</span>
          </div>
        </div>
        <div v-if="contest.active" class="text-end">
          <small>Время проведения: {{ contest.date.from_visual }} — {{ contest.date.to_visual }}</small>
        </div>
      </router-link>
    </template>
    <div v-else>Нет розыгрышей</div>
  </div>
</template>

<script>
export default {
  name: 'ContestsList',

  props: {
    value: {
      type: Array,
      default: () => [],
    },
  },
}
</script>
