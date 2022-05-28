<template>
  <div v-show="display" class="tabs-content-item">
    <slot/>
  </div>
</template>

<script>
export default {
  name: 'TabsItem',

  inject: ['tabs'],

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

  created ()
  {
    this.index = this.tabs.count++
  },

  computed: {
    current ()
    {
      return this.tabs.current
    },
    display ()
    {
      return this.index === this.current
    }
  },
}
</script>
