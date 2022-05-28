<template>
  <li
    v-if="user.id"
    class="nav-item dropdown"
    :data-id="user.id"
  >
    <span
      class="nav-link dropdown-toggle"
      id="navbarDropdown"
      role="button"
      data-bs-toggle="dropdown"
      aria-expanded="false"
    >
      {{ user.name }}
    </span>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
      <li>
        <button class="dropdown-item" @click="toggleTheme">Switch Light/Dark</button>
      </li>
      <li><hr class="dropdown-divider"></li>
      <li><button class="dropdown-item" @click="logout">Logout</button></li>
    </ul>
  </li>
</template>

<script>
import { logout } from '@/services/auth'

export default {
  name: 'Profile',

  computed: {
    user () {
      return this.$store.getters['auth/user']
    },
    themes ()
    {
      return this.$store.getters['settings/themes']
    },
  },

  methods: {
    async logout ()
    {
      const { success } = await logout()
      if (success)
      {
        this.$router.push({ name: 'login' })
      }
    },

    toggleTheme ()
    {
      const data = { ...this.themes }

      this.themes.list.forEach(o =>
      {
        if (o.name !== this.themes.current)
        {
          data.current = o.name
          return true
        }
      })
      this.$store.dispatch('settings/setThemes', data)
    },
  },
}
</script>

<style lang="scss" scoped></style>
