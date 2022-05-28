import store from '@/store'

// TODO: перенести!
function canAdmin ()
{
  return store.getters['auth/canAdmin']
}

export default [
  {
    name: 'home',
  },
  {
    name: 'about',
  },
  {
    title: 'Пользователи',
    name: 'users',
    show ()
    {
      return canAdmin()
    },
  },
  {
    name: 'settings',
  },
  {
    name: 'system',
    show ()
    {
      return canAdmin()
    },
  },
]
