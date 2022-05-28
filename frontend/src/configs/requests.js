export default {
  login: {
    method: 'POST',
    url: '/login'
  },
  logout: {
    method: 'GET',
    url: '/logout'
  },

  qr: {
    method: 'POST',
    url: '/contests/:id/qr',
  },

  users: {
    get: {
      method: 'GET',
      url: '/users/:id'
    },
    list: {
      method: 'GET',
      url: '/users'
    },
    update: {
      method: 'PATCH',
      url: '/users/:id'
    },
    create: {
      method: 'POST',
      url: '/users'
    },
    delete: {
      method: 'DELETE',
      url: '/users/:id'
    },
    winner: {
      method: 'GET',
      url: '/users/:id/winner'
    },
    participant: {
      method: 'PATCH',
      url: '/users/:id/participant'
    },
  },

  companies: {
    get: {
      method: 'GET',
      url: '/companies/:id'
    },
    list: {
      method: 'GET',
      url: '/companies'
    },
    update: {
      method: 'PATCH',
      url: '/companies/:id'
    },
    create: {
      method: 'POST',
      url: '/companies'
    },
    delete: {
      method: 'DELETE',
      url: '/companies/:id'
    },
  },

  contests: {
    get: {
      method: 'GET',
      url: '/contests/:id'
    },
    list: {
      method: 'GET',
      url: '/contests'
    },
    update: {
      method: 'PATCH',
      url: '/contests/:id'
    },
    create: {
      method: 'POST',
      url: '/contests'
    },
    delete: {
      method: 'DELETE',
      url: '/contests/:id'
    },
    participants: {
      method: 'GET',
      url: '/contests/:id/participants'
    },
  },

  templates: {
    get: {
      method: 'GET',
      url: '/templates/:id'
    },
    list: {
      method: 'GET',
      url: '/templates'
    },
    update: {
      method: 'PATCH',
      url: '/templates/:id'
    },
    create: {
      method: 'POST',
      url: '/templates'
    },
    delete: {
      method: 'DELETE',
      url: '/templates/:id'
    },
  },

  careers: {
    list: {
      method: 'GET',
      url: '/careers'
    },
    get: {
      method: 'GET',
      url: '/careers/:id'
    },
    update: {
      method: 'PATCH',
      url: '/careers/:id'
    },
    create: {
      method: 'POST',
      url: '/careers'
    },
    delete: {
      method: 'DELETE',
      url: '/careers/:id'
    },
  },

  roles: {
    get: {
      method: 'GET',
      url: '/roles/:id'
    },
    list: {
      method: 'GET',
      url: '/roles'
    },
  },

  statuses: {
    list: {
      method: 'GET',
      url: '/statuses'
    },
  },

  settings: {
    get: {
      method: 'GET',
      url: '/settings/:id'
    },
    list: {
      method: 'GET',
      url: '/settings'
    },
    update: {
      method: 'PATCH',
      url: '/settings/:id'
    },
    updates: {
      method: 'PATCH',
      url: '/settings/updates'
    },
    create: {
      method: 'POST',
      url: '/settings'
    },
    delete: {
      method: 'DELETE',
      url: '/settings/:id'
    },
  },

  settingsTypes: {
    list: {
      method: 'GET',
      url: '/settings-types'
    },
  },

  system: {
    log: {
      method: 'GET',
      url: '/system/log'
    },
    tgStatus: {
      method: 'GET',
      url: '/system/tg/status'
    },
    tgAuth: {
      method: 'POST',
      url: '/system/tg/auth'
    },
    tgLogout: {
      method: 'GET',
      url: '/system/tg/logout'
    },
  },

}
