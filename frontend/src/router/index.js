import { createWebHistory, createRouter } from 'vue-router'
import store from '@/store'

import routes from '@/configs/routes'

import guest from './middleware/guest'
import auth from './middleware/auth'
import admin from './middleware/admin'

import middlewarePipeline from './middlewarePipeline'

const middlewaresList = {
  guest,
  auth,
  admin,
}

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach(async (to, from, next) =>
{
  if (to.meta.middleware)
  {
    const { middleware } = to.meta
    const middlewareMethods = []
    const context = {
      to,
      from,
      next,
      store,
    }

    middleware.forEach(name =>
    {
      middlewareMethods.push(middlewaresList[name])
    })

    return middlewareMethods[0]({
      ...context,
      next: middlewarePipeline(context, middlewareMethods, 1)
    })
  }
  return next()
})

export default router
