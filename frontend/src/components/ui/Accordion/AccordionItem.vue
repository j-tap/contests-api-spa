<template>
  <div class="accordion-collapse">
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button
          class="accordion-button"
          type="button"
          @click="toggle"
        >{{ title }}</button>
      </h2>
      <div v-show="display" class="accordion-collapse">
        <div ref="content" class="accordion-body">
          <slot/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AccordionItem',

  inject: ['accordion'],

  props: {
    title: {
      type: String,
      required: true,
    },
  },

  data () {
    return {
      index: null,
    }
  },

  computed: {
    current ()
    {
      return this.accordion.current
    },
    display ()
    {
      return (this.current.includes(this.index))
    },
  },

  created ()
  {
    this.index = this.accordion.count++
    if (this.display)
    {
      this.show()
    }
  },

  methods: {
    toggle ()
    {
      if (this.display)
      {
        this.hide()
      }
      else {
        this.show()
      }
    },

    show ()
    {
      const ind = this.accordion.current.indexOf(this.index)
      if (ind < 0)
      {
        this.accordion.current.push(this.index)
      }
    },

    hide ()
    {
      const ind = this.accordion.current.indexOf(this.index)
      if (ind >= 0)
      {
        this.accordion.current.splice(ind, 1)
      }
    },
  },

}
</script>
