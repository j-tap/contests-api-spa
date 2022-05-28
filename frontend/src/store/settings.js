import webStorage from '@/plugins/WebStorage'
import { getClientTheme } from '@/libs/helpers/data'

const defaultThemes = {
  list: [
    {
      name: 'dark',
    },
    {
      name: 'light',
    },
  ],
  current: getClientTheme(),
}

export default {
  namespaced: true,

  state () {
    return {
      themes: webStorage.get('settings.themes') || defaultThemes,
    }
  },

  getters: {
    themes: (state) => state.themes
  },

  mutations: {
    setThemes (state, payload) {
      const themes = {
        list: payload.list,
        current: payload.current,
      }
      state.themes = themes
    }
  },

  actions: {
    setThemes ({ commit }, payload)
    {
      commit('setThemes', payload)
    },
  },
}
