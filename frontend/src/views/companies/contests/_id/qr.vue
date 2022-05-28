<template>
  <LayoutBlank>
    <QrCode
      :value="qrData"
      @click:qr="getQrData"
    />
  </LayoutBlank>
</template>

<script>
import serviceQr from '@/services/qr'

import LayoutBlank from '@/layouts/LayoutBlank'
import QrCode from '@/components/sections/QrCode'

export default {
  name: 'Qr',

  components: {
    LayoutBlank,
    QrCode,
  },

  data() {
    return {
      qrData: {},
    }
  },

  created ()
  {
    this.getQrData()
  },

  beforeMount ()
  {
    this.toggleFullscreen()
  },

  beforeUnmount ()
  {
    this.toggleFullscreen()
  },

  methods: {
    async getQrData()
    {
      const { id_contest } = this.$route.params
      const { data } = await serviceQr.getQr(id_contest)
      this.qrData = { ...data }
    },

    toggleFullscreen ()
    {
      const elem = document.body

      if (!document.fullscreenElement)
      {
        elem.requestFullscreen().catch(err =>
        {
          console.warn(`Error fullscreen: ${err.message} (${err.name})`)
        })
      }
      else {
        document.exitFullscreen()
      }
    },

  },
}
</script>
