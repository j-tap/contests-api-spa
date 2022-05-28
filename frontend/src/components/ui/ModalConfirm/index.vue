<template>
  <Modal
    v-model="display"
    :title="title"
    :options="options"
    class="modal-confirm"
  >
    <div class="d-flex justify-content-between">
      <Btn @click="accept">{{ btns.accept.text }}</Btn>
      <Btn color="secondary" @click="decline(false)">{{ btns.decline.text }}</Btn>
    </div>
  </Modal>
</template>

<script>
import Modal from '@/components/ui/Modal'
import Btn from '@/components/ui/Btn'

export default {
	name: 'ModalConfirm',

  components: {
    Modal,
    Btn,
  },

  props: {
    modelValue: {
      type: Boolean,
      default: false,
    },

    title: {
      type: String,
      default: null,
    },

    buttons: {
      type: Object,
      default: () => ({}),
    },

    action: {
      type: Function,
      default: () => {},
    },
  },

  data() {
    return {
      buttonsDefault: {
        accept: {
          text: 'Продолжить',
        },
        decline: {
          text: 'Отмена',
        },
      }
    }
  },

  computed: {
    display: {
      get ()
      {
        return this.modelValue
      },
      set (value)
      {
        this.show(value)
      },
    },

    options()
    {
      return { close: { display: false } }
    },

    btns ()
    {
      return { ...this.buttonsDefault, ...this.buttons }
    },
  },

  methods: {
    accept ()
    {
      this.action()
    },
    decline ()
    {
      this.show(false)
    },
    show (display = true)
    {
      this.$emit('update:modelValue', display)
    },
  },

}
</script>

<style scoped lang="scss" src="./style.scss"></style>
