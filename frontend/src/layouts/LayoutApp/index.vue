<template>
  <section class="page">
      <Navbar/>
      <main class="page-main">
        <div class="container-fluid pt-3">
          <slot/>
        </div>
      </main>
  </section>
</template>

<script>
import Navbar from '@/components/main/Navbar'

export default {
  name: 'LayoutApp',

  components: {
    Navbar,
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
