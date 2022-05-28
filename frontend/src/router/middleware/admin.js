export default function auth ({ next, store })
{
  const { role } = store.getters['auth/user']

  if (!role || role.id > 1)
  {
    return next({
      name: 'home'
    })
  }
  return next()
}
