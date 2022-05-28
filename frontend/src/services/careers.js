import { reactive } from 'vue'
import store from '@/store'
import Service from './service'

class ServiceCareer extends Service
{
  entitiesName = 'careers'
  entityName = 'career'

  state = reactive({
    careers: [],
    career: {},
  })

  static _instance

  static _getInstance ()
  {
    return ServiceCareer._instance || (ServiceCareer._instance = new ServiceCareer())
  }

  getCareers ()
  {
    return this.state.careers
  }
  getCareer ()
  {
    return this.state.career
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
      return { name }
    })

    if (response.success)
    {
      const { code } = response
      const message = 'Настройка создана'
      store.dispatch('notify/add', { code, message })
    }

    return response
  }

  async updateItem (id, form)
  {
    const response = await this.update(form, (serviceForm) =>
    {
      const name = serviceForm.name.value
      return { id, name }
    })

    if (response.success)
    {
      const index = this.state.careers.findIndex(o => o.id === response.data.id)
      if (index >= 0)
      {
        this.state.careers[index] = response.data
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
      const message = 'Деятельность удалена'
      store.dispatch('notify/add', { code, message })
    }

    return response
  }

}

export default ServiceCareer._getInstance()
