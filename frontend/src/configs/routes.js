import Login from '@/views/login'
import Page404 from '@/views/page404'
import Home from '@/views/home'
import About from '@/views/about'
import Users from '@/views/users'
import Company from '@/views/companies/_id'
import User from '@/views/companies/user'
import Contest from '@/views/companies/contests/_id/index'
import Qr from '@/views/companies/contests/_id/qr'
import Random from '@/views/companies/contests/_id/random'
import Settings from '@/views/settings'
import System from '@/views/system'

export default [
  {
		path: '/login',
		name: 'login',
		component: Login,
		meta: {
      middleware: [
        'guest',
      ],
    },
	},
  {
    path: '/',
    name: 'home',
    component: Home,
    meta: {
      title: 'Главная',
      middleware: [
        'auth',
      ],
    },
  },
  {
    path: '/about',
    name: 'about',
    component: About,
    meta: {
      title: 'Информация',
      middleware: [
        'auth',
      ],
    },
  },
  {
    path: '/users',
    name: 'users',
    component: Users,
    meta: {
      title: 'Пользователи системы',
      middleware: [
        'auth',
        'admin',
      ],
    },
  },

  {
    path: '/system',
    name: 'system',
    component: System,
    meta: {
      title: 'Система',
      middleware: [
        'auth',
        'admin',
      ],
    },
  },

  {
    path: '/companies',
    name: 'companies',
    redirect: { name: 'home' },
  },
  {
    path: '/companies/:id_company',
    name: 'company',
    component: Company,
    meta: {
      title: 'Розыгрыши компании',
      breadcrumb: ['home', 'company'],
      middleware: [
        'auth',
      ],
    },
  },
  {
    path: '/companies/:id_company/users/:id_user',
    name: 'user',
    component: User,
    meta: {
      title: 'Страница пользователя',
      breadcrumb: ['home', 'company', 'user'],
      middleware: [
        'auth',
        'admin',
      ],
    },
  },

  {
    path: '/companies/:id_company/contests',
    name: 'contests',
    redirect: { name: 'home' },
  },
  {
    path: '/companies/:id_company/contests/:id_contest',
    name: 'contest',
    component: Contest,
    meta: {
      title: 'Страница розыгрыша',
      breadcrumb: ['home', 'company', 'contest'],
      middleware: [
        'auth',
      ],
    },
  },
  {
    path: '/companies/:id_company/contests/:id_contest/qr',
    name: 'qr',
    component: Qr,
    meta: {
      title: 'QR для участников',
      breadcrumb: ['home', 'company', 'contest', 'qr'],
      middleware: [
        'auth',
      ],
    },
  },
  {
    path: '/companies/:id_company/contests/:id_contest/random',
    name: 'random',
    component: Random,
    meta: {
      title: 'Розыгрыш',
      breadcrumb: ['home', 'company', 'contest', 'random'],
      middleware: [
        'auth',
      ],
    },
  },
  {
    path: '/settings',
    name: 'settings',
    component: Settings,
    meta: {
      title: 'Настройки',
      breadcrumb: ['home', 'settings'],
      middleware: [
        'auth',
      ],
    },
  },

  {
    path: '/:pathMatch(.*)*',
    name: '404',
    component: Page404,
  }
]
