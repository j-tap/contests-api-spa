<template>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li
        v-for="(link, i) in list"
        :key="`breadcrumb-link-${i}`"
        :class="['breadcrumb-item', { 'active': link.current }]"
      >
        <router-link v-if="link.name && !link.current" :to="{ name: link.name }">{{ link.title }}</router-link>
        <span v-else>{{ link.title }}</span>
      </li>
    </ol>
  </nav>
</template>

<script>
export default {
  name: 'Breadcrumb',

  data() {
    return {
      routes: this.$router.getRoutes(),
    }
  },

  computed: {
    list ()
    {
      const result = []
      const { name: nameCurrent, meta: { breadcrumb } } = this.$route

      if (breadcrumb)
      {
        breadcrumb.forEach(nameRoute =>
        {
          const route = this.routes.find(o => o.name === nameRoute)
          const { name, meta: { title } } = route
          const current = name === nameCurrent

          result.push({
            title,
            name,
            current,
          })
        })
      }

      return result
    }
  },
}
</script>
