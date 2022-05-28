<template>
  <div class="list-group">
    <template v-if="value.length">
      <router-link
        v-for="(user, i) in value"
        :key="`user-${i}`"
        class="list-group-item list-group-item-action"
        :to="{ name: 'user', params: { id_user: user.id } }"
      >{{ user.name }}</router-link>
    </template>
    <div v-else>Нет менеджеров</div>
  </div>
</template>

<script>
export default {
	name: 'ManagersList',

  props: {
    value: {
      type: Array,
      default: () => [],
    },
  },
}
</script>
