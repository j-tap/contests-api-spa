import { reactive } from 'vue'
import ServiceMain from './ServiceMain'
import store from '@/store'
import Service from './service'
import { nestedCopy } from '@/libs/helpers/convertData'

class ServiceUsers extends Service
{
  entitiesName = 'users'
  entityName = 'user'

  state = reactive({
    users: [],
    user: {},
  })

  static _instance

  static _getInstance ()
  {
    return ServiceUsers._instance || (ServiceUsers._instance = new ServiceUsers())
  }

  getUsers ()
  {
    return this.state.users
  }
  getUser ()
  {
    return this.state.user
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
      const email = serviceForm.email.value
      const password = serviceForm.password.value
      const password_confirmation = serviceForm.password_confirmation.value
      const role_id = serviceForm.role_id.value
      const companies = serviceForm.companies.value
      return { name, email, password, password_confirmation, role_id, companies }
    })

    if (response.success)
    {
      const { code } = response
      const message = 'Пользователь создан'
      store.dispatch('notify/add', { code, message })
    }

    return response
  }

  async updateItem (id, form)
  {
    const response = await this.update(form, (serviceForm) =>
    {
      const role_id = serviceForm.role_id.value
      const companies = serviceForm.companies.value
      return { id, role_id, companies }
    })
    return response
  }

  async deleteItem (id)
  {
    const response = await this.delete(id)
    if (response.success)
    {
      const { code } = response
      const message = 'Менеджер удалён'
      store.dispatch('notify/add', { code, message })
    }
    return response
  }

  getTable ()
  {
    const users = this.getUsers()
    const list = nestedCopy(users)
    const result = { list: [] }

    result.header = [
      { key: 'id', title: 'ID' },
      { key: 'name', title: 'Имя' },
      { key: 'email', title: 'E-mail' },
      { key: 'role', title: 'Роль' },
      { key: 'companies', title: 'Компании' },
    ]
    
    if (list.length)
    {
      result.list = list.map(o =>
      {
        const companies = o.companies && o.companies.length ? o.companies.map(c => c.name).join(', ') : 'None'

        return {
          id: o.id,
          name: o.name,
          email: o.email,
          role: o.role?.name,
          companies,
        }
      })
    }

    return result
  }

  async getCompanies ()
  {
    const service = new ServiceMain('companies/list')
    const response = await service.send()
    const result = response.data || []
    return result.map(o => ({ value: o.id, text: o.name }))
  }

  async getRoles ()
  {
    const service = new ServiceMain('roles/list')
    const response = await service.send()
    const result = response.data || []
    return result.map(o => ({ value: o.id, text: o.name }))
  }
}

export default ServiceUsers._getInstance()
