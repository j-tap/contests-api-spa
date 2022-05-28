import webStorage from '@/plugins/WebStorage'

export default {
  namespaced: true,

  state () {
    return {
      token: webStorage.get('token'),
      user: webStorage.get('user'),
    }
  },

  getters: {
    loggedIn: (state) => !!state.token && !!state.user.id,
    token: (state) => state.token,
    user: (state) => state.user || {},
    canAdmin: (state) =>
    {
      const { user } = state
      if (user.id)
      {
        return (user.role?.id === 1)
      }
      return false
    },
  },

  mutations: {
    setToken (state, token = null) {
      state.token = token
    },
    setUser (state, payload = {}) {
      const user = {}
      user.id = payload.id || null
      user.name = payload.name || null
      user.email = payload.email || null
      user.role = payload.role || null
      state.user = user
    }
  },

  actions: {
    login ({ commit }, payload)
    {
      commit('setToken', payload.token)
      commit('setUser', payload.user)
    },

    logout ({ commit })
    {
      commit('setToken')
      commit('setUser')
    },
  },
}
