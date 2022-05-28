import ServiceMain from './ServiceMain'
import store from '@/store'

export async function login (form)
{
  const service = new ServiceMain('login', form)
  const response = await service.send((serviceForm) =>
  {
    const email = serviceForm.email.value
    const password = serviceForm.password.value
    return { email, password }
  })

  if (response.success)
  {
    store.dispatch('auth/login', response.data)
  }

  return response
}

export async function logout ()
{
  const service = new ServiceMain('logout')
  const response = await service.send()
  store.dispatch('auth/logout')
  return response
}
