import { reactive } from 'vue'
import store from '@/store'
import Service from './service'

class ServiceTemplate extends Service
{
  entitiesName = 'templates'
  entityName = 'template'

  state = reactive({
    templates: [],
    template: {},
  })

  static _instance

  static _getInstance ()
  {
    return ServiceTemplate._instance || (ServiceTemplate._instance = new ServiceTemplate())
  }

  getTemplates ()
  {
    return this.state.templates
  }
  getTemplate ()
  {
    return this.state.template
  }

  async fetchAll ()
  {
    return await this.index()
  }

  async fetchItem (id)
  {
    return await this.show(id)
  }

  async createItem (form)
  {
    const response = await this.create(form, (serviceForm) =>
    {
      const name = serviceForm.name.value
      // const key = serviceForm.key.value
      return { name }
    })

    if (response.success)
    {
      const { code } = response
      const message = 'Шаблон создан'
      store.dispatch('notify/add', { code, message })
    }

    return response
  }

  async updateItem (id, form)
  {
    const response = await this.update(form, (serviceForm) =>
    {
      const name = serviceForm.name.value
      // const key = serviceForm.key.value
      return { id, name }
    })

    if (response.success)
    {
      const index = this.state.templates.findIndex(o => o.id === response.data.id)
      if (index >= 0)
      {
        this.state.templates[index] = response.data
      }
    }

    return response
  }

  async deleteItem (id)
  {
    const response = await this.delete(id)

    if (response.success)
    {
      const { code } = response
      const message = 'Шаблон удален'
      store.dispatch('notify/add', { code, message })
    }

    return response
  }

}

export default ServiceTemplate._getInstance()
