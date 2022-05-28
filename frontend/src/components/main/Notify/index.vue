<template>
  <div class="notifications">
    <div
      v-show="show"
      v-for="(item, i) in list"
      :key="`notify-${i}`"
      :class="`notify alert alert-${item.type}`"
      role="alert"
    >
      <div class="d-flex align-items-center">
        <button
          type="button"
          class="btn-close me-2"
          aria-label="Close"
          @click="onHide(item.key)"
        ></button>
        <span>{{ item.message }}</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Notify',

  computed: {
    show()
    {
      return this.list && this.list.length
    },
    list()
    {
      return this.$store.getters['notify/list']
    }
  },

  methods: {
    onHide(key)
    {
      this.$store.dispatch('notify/clear', key)
    },
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
