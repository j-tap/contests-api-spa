import webStorage from '@/plugins/WebStorage'

export default function subscribeMutations(store)
{
  store.subscribe(({ payload, type }) =>
  {
    switch (type)
    {
      case 'auth/setToken':
        if (payload)
        {
          webStorage.set('token', payload)
        }
        else {
          webStorage.delete('token')
        }
        break

      case 'auth/setUser':
        if (payload)
        {
          webStorage.set('user', payload)
        }
        else {
          webStorage.delete('user')
        }
        break

        case 'settings/setThemes':
          if (payload)
          {
            webStorage.set('settings.themes', payload)
          }
          else {
            webStorage.delete('settings.themes')
          }
          break
    }
  })
}
