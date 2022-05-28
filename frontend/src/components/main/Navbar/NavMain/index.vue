<template>
  <button class="navbar-toggler" type="button" @click="showMenu">
    <span class="navbar-toggler-icon"></span>
  </button>
  <nav v-show="displayMenu" class="collapse navbar-collapse">
    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
      <li
        v-for="item in items"
        :key="`menu-item-${item.name}`"
        class="nav-item"
      >
        <router-link
          :to="{ name: item.name }"
          :class="item.classLink"
        >{{ item.title }}</router-link>
      </li>
      <Profile/>
    </ul>
  </nav>
</template>

<script>
import items from '@/configs/menu'
import Profile from '../Profile'

export default {
  name: 'NavMain',

  components: {
    Profile,
  },

  data() {
    return {
      displayMenu: false,
      routes: this.$router.getRoutes(),
    }
  },

  computed: {
    items()
    {
      const result = [...items.filter(o => (o.show && o.show()) || !o.show)]

      return result.map(item =>
      {
        const route = this.routes.find(o => o.name === item.name)

        if (!route)
        {
          throw `Route '${item.name}' not found in routes file`
        }

        const { meta: { title } } = route
        const classes = ['nav-link']
        const isActive = this.current === item.name

        if (isActive)
        {
          classes.push('active')
        }

        return {
          ...item,
          title: item.title || title,
          classLink: classes.join(' '),
          isActive,
        }
      })
    },
    current()
    {
      return this.$route.name
    },
  },

  methods: {
    showMenu ()
    {
      this.displayMenu = !this.displayMenu
    },
  },
}
</script>

<style lang="scss" scoped></style>
