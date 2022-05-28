<template>
  <form class="form" @submit.prevent.stop="onSubmit">
    <slot/>
    <Btn type="submit" size="lg">{{ submitText }}</Btn>
  </form>
</template>

<script>
import Btn from '@/components/ui/Btn'

export default {
	name: 'Form',

  components: {
    Btn,
	},

  props: {
    submitText: {
      type: String,
      default: 'Сохранить',
    },
  },


  methods: {
    onSubmit ()
    {
      this.$emit('submit:form')
    },
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
