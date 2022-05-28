<template>
  <div class="tabs">
    <ul class="tabs__nav nav nav-tabs">
      <li
        v-for="(tab, index) in tabsList"
        :key="tab.title"
        class="nav-item"
        @click="setCurrentTab(index)"
      >
        <button :class="['nav-link', { active: tab.active }]">{{ tab.title }}</button>
      </li>
    </ul>
    <slot/>
  </div>
</template>

<script>
export default {
	name: 'Tabs',

  props: {
    modelValue: {
      type: Number,
      default: 0,
    },
  },

  data ()
  {
    return {
      items: this.$slots.default().filter(o => o.type.name === 'TabsItem'),
      tabs: {
        current: this.modelValue,
        count: 0,
      },
    }
  },

  provide ()
  {
    return {
      tabs: this.tabs,
    }
  },

  computed: {
    tabsList ()
    {
      return this.items.map((o, i) => ({ ...o.props, active: i === this.modelValue }))
    },
  },

  watch: {
    modelValue (value)
    {
      this.tabs.current = value
    }
  },

  methods: {
    setCurrentTab (index)
    {
      this.$emit('update:modelValue', index)
    },
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
