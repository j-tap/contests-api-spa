<template>
  <div :class="['block-qr', data.theme]" :style="styleBlock">
    <div
      class="block-qr__code"
      v-html="data.qr"
      @click="onClickQr"
    />
    <button class="block-qr__btn-back" @click="backToContest"/>
    <div class="d-none">{{ data.link }}</div>
  </div>
</template>

<script>
export default {
	name: 'QrCode',

  props: {
    value: {
      type: Object,
      default: () => ({}),
    },
  },

  computed: {
    data ()
    {
      return this.value
    },
    styleBlock ()
    {
      return {
        backgroundColor: this.data.bg,
      }
    }
  },

  methods: {
    onClickQr ()
    {
      this.$emit('click:qr')
    },

    backToContest ()
    {
      const { id_contest } = this.$route.params
      this.$router.push({ name: 'contest', params: { id_contest } })
    },
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
