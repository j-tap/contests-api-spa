<template>
  <div
    :class="['modal', 'fade', { show: display }]"
    :style="styles"
    tabindex="-1"
  >
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ title }}</h5>
          <button
            v-if="optionsModal.close.display"
            type="button"
            class="btn-close"
            aria-label="Close"
            @click="show(false)"
          ></button>
        </div>
        <div class="modal-body">
          <slot/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mergeObjects } from '@/libs/helpers/convertData'

export default {
	name: 'Modal',

  props: {
    modelValue: {
      type: Boolean,
      default: false,
    },

    title: {
      type: String,
      default: null,
    },

    options: {
      type: Object,
      default: () => ({})
    },
  },

  data() {
    return {
      optionsDefault: {
        close: {
          display: true,
        },
      },
    }
  },

  computed: {
    display ()
    {
      return this.modelValue
    },

    styles ()
    {
      const result = {}

      if (this.display)
      {
        result.display = 'block'
      }
      return result
    },

    optionsModal ()
    {
      return mergeObjects(this.optionsDefault, this.options)
    },
  },

  watch: {
    display (value)
    {
      this.$store.dispatch('variables/setBackdropShow', value)
    },
  },

  beforeMount ()
  {
    document.addEventListener('keydown', this.onKeydownEvent, false)
  },

  beforeUnmount ()
  {
    document.removeEventListener('keydown', this.onKeydownEvent)
  },

  methods: {
    onKeydownEvent (event)
		{
			if (event.key === 'Escape')
			{
				this.show(false)
			}
		},

    show (display = true)
    {
      this.$emit('update:modelValue', display)
    },
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
