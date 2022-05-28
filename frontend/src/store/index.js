import { Store } from 'vuex'

import subscribeMutations from './plugins/subscribeMutations'

import auth from './auth'
import notify from './notify'
import settings from './settings'
import variables from './variables'

const store = {
  modules: {
    auth,
    notify,
    settings,
    variables,
  },
  plugins: [
    subscribeMutations,
  ],
}

export default new Store (store)
