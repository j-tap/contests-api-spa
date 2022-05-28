<template>
  <router-view/>
  <Backdrop/>
  <Notify/>
  <PreloaderOnPage v-show="!!globalLoading"/>
</template>

<script>
import 'bootstrap'

import Notify from '@/components/main/Notify'
import PreloaderOnPage from '@/components/main/PreloaderOnPage'
import Backdrop from '@/components/ui/Backdrop'

export default {
  components: {
    Notify,
    PreloaderOnPage,
    Backdrop,
  },

  computed: {
    themes ()
    {
      return this.$store.getters['settings/themes']
    },
    globalLoading ()
    {
      return this.$store.getters['variables/loading']
    },
  },

  watch: {
    themes()
    {
      this.setAppTheme()
    },
  },

  created ()
  {
    this.setAppTheme()
  },

  methods: {
    setAppTheme ()
    {
      const { body } = document
      const theme = this.themes.current

      this.themes.list.forEach(o => {
        body.classList.remove(o.name)
      })

      body.classList.add(theme)
    },
  },
}
</script>

<style lang="scss" src="@/assets/scss/app.scss"></style>
