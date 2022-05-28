<template>
  <section class="page">
    <main class="page-guest">
      <div class="container-fluid">
        <slot/>
      </div>
    </main>
  </section>
</template>

<script>
export default {
  name: 'LayoutGuestCenter',
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
