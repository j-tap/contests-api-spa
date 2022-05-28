import { createApp } from 'vue'
import App from '@/App.vue'

import axios from 'axios'
import VueAxios from 'vue-axios'

import store from '@/store'
import router from '@/router'
import Api from '@/plugins/api'

import globalMixin from '@/mixins/global'

const app = createApp(App)

app.use(store)
app.use(router)
app.use(VueAxios, axios)
app.use(Api, { store })

app.mixin(globalMixin)

app.mount('#app')
