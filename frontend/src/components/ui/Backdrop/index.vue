<template>
  <div v-show="show" :class="['modal-backdrop', 'fade', { show }]"></div>
</template>

<script>
export default {
	name: 'Backdrop',

  computed: {
    show ()
    {
      return this.$store.getters['variables/backdropShow']
    },
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
