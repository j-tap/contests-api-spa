<template>
  <div
    class="preloader-on-page spinner-border"
    role="status"
    :title="globalLoading"
  >
    <span class="visually-hidden">Загрузка...</span>
  </div>
</template>

<script>
export default {
	name: 'PreloaderOnPage',

  computed: {
    globalLoading ()
    {
      return this.$store.getters['variables/loading']
    },
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
