export default {
  computed: {
    canAdmin ()
    {
      const { role } = this.$store.getters['auth/user']
      return role?.id === 1
    },
  },

  methods: {},
}
