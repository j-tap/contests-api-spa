export default {
  namespaced: true,

  state () {
    return {
      _timeDelay: 5000,
      _types: {
        '1': 'warning',
        '2': 'success',
        '3': 'warning',
        '4': 'warning',
        '5': 'danger',
      },
      _model: {
        code: null,
        message: null,
        type: null,
        key: null,
      },
      list: [],
    }
  },

  getters: {
    list: (state) => state.list,
    last: (state) =>
    {
      const ind = state.list.length - 1
      return ind >= 0 ? state.list[ind] : { ...state._model }
    },
  },

  mutations: {
    set (state, payload = []) {
      state.list = payload
    }
  },

  actions: {
    add ({ commit, state, dispatch }, payload = {})
    {
      const { list, _model, _types } = state
      const result = [ ...list ]
      const data = {}
      Object.keys(_model).forEach(k =>
        {
          data[k] = payload[k] || _model[k]
        })

      const firstLetterCode = payload.code ? payload.code.toString().substring(0, 1) : 3
      const type = _types[firstLetterCode]
      const key = result.length

      Object.assign(data, { type, key })
      result.push(data)

      commit('set', result)

      setTimeout(() => {
        dispatch('clear', key)
      }, state._timeDelay)
    },

    clear ({ commit, state }, key = null)
    {
      let result = []

      if (typeof key === 'number')
      {
        const { list } = state
        result = [...list]
        const index = list.findIndex(o => o.key === key)

        if (index >= 0)
        {
          result.splice(index, 1)
        }
      }

      commit('set', result)
    },
  },
}
