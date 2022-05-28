<template>
  <header class="page-header mb-3">
    <Breadcrumb/>
    <div class="d-lg-flex justify-content-between align-items-center">
      <Title class="mb-3">
        <slot name="title"/>
      </Title>
      <div class="d-flex flex-wrap justify-content-end">
        <slot name="right"/>
      </div>
    </div>
  </header>
</template>

<script>
import Breadcrumb from '@/components/ui/Breadcrumb'
import Title from '@/components/ui/Title'

export default {
	name: 'PageHeader',

  components: {
    Breadcrumb,
    Title,
  },
}
</script>
