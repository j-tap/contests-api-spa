<template>
  <LayoutBlank>
    <RandomRuller
      :participants="participants"
      @setWinner="setWinner"
      @final="final"
    />
  </LayoutBlank>
</template>

<script>
import serviceRandom from '@/services/random'

import LayoutBlank from '@/layouts/LayoutBlank'
import RandomRuller from '@/components/sections/RandomRuller'

export default {
  name: 'Random',

  components: {
    LayoutBlank,
    RandomRuller,
  },

  data() {
    return {
      participantsList: [],
    }
  },

  computed: {
    participants ()
    {
      const list = this.participantsList
      return list.filter(o => !o.winner)
    },
  },

  created() {
    this.getParticipants()
  },

  methods: {
    async getParticipants ()
    {
      const { id_contest } = this.$route.params
      const participants = await serviceRandom.getParticipants(id_contest)

      this.participantsList = participants.data
    },

    async setWinner (id)
    {
      const response = await serviceRandom.setWinner(id)
      if (response.success)
      {
        const { id } = response.data
        const ind = this.participantsList.findIndex(o => o.id === id)
        this.participantsList.splice(ind, 1)
      }
    },

    final ()
    {
      this.$router.push({ name: 'contest' })
    },
  },
}
</script>
