<template>
  <header class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <Logo/>
      <NavMain/>
    </div>
  </header>
</template>

<script>
import Logo from './Logo'
import NavMain from './NavMain'

export default {
  name: 'Navbar',

  components: {
    Logo,
    NavMain,
  },
}
</script>
