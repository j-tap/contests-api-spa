export default {
  namespaced: true,

  state () {
    return {
      backdropShow: false,
      loading: 0,
    }
  },

  getters: {
      backdropShow: (state) => state.backdropShow,
      loading: (state) => state.loading,
  },

  mutations: {
    setBackdropShow (state, payload)
    {
      state.backdropShow = payload
    },
    setLoading (state, payload)
    {
      state.loading = payload
    },
  },

  actions: {
    setBackdropShow ({ commit }, payload)
    {
      commit('setBackdropShow', !!payload)
    },

    setLoading ({ commit, state }, payload = true)
    {
      const current = state.loading
      const value = payload ? 1 : -1
      const calculate = current + value
      const result = Math.max(calculate, 0)
      commit('setLoading', result)
    },
  },
}
