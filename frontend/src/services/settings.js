import { reactive } from 'vue'
import ServiceMain from './ServiceMain'
import store from '@/store'
import Service from './service'
import serviceContests from './contests'
import serviceCompanies from './companies'

class ServiceSettings extends Service
{
  entitiesName = 'settings'
  entityName = 'setting'

  state = reactive({
    settings: [],
    setting: {},
  })

  static _instance

  static _getInstance ()
  {
    return ServiceSettings._instance || (ServiceSettings._instance = new ServiceSettings())
  }

  getSettings ()
  {
    return this.state.settings
  }
  getSetting ()
  {
    return this.state.setting
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
      const key = serviceForm.key.value
      const name = serviceForm.name.value
      const value = serviceForm.value.value
      const setting_type_id = serviceForm.setting_type_id.value
      const company_id = serviceForm.company_id.value
      const contest_id = serviceForm.contest_id.value
      const description = serviceForm.description.value
      return { key, name, value, setting_type_id, company_id, contest_id, description }
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
      const key = serviceForm.key.value
      const name = serviceForm.name.value
      const value = serviceForm.value.value
      const setting_type_id = serviceForm.setting_type_id.value
      const company_id = serviceForm.company_id.value
      const contest_id = serviceForm.contest_id.value
      const description = serviceForm.description.value
      return { id, key, name, value, setting_type_id, company_id, contest_id, description }
    })

    if (response.success)
    {
      const index = this.state.settings.findIndex(o => o.id === response.data.id)
      if (index >= 0)
      {
        this.state.settings[index] = response.data
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
      const message = 'Настройка удалена'
      store.dispatch('notify/add', { code, message })
    }

    return response
  }

  async updateMultiple (form)
  {
    const service = new ServiceMain('settings/updates', form)
    const response = await service.send((serviceForm) =>
    {
      const list = []
      Object.keys(serviceForm).forEach(k =>
      {
        const id = serviceForm[k].parameters.id
        const value = serviceForm[k].value
        const key = serviceForm[k].parameters.key
        list.push({ id, key, value })
      })
      return { list }
    })

    if (response.success)
    {
      const { code } = response
      const message = 'Настройки обновлены'
      store.dispatch('notify/add', { code, message })
    }
    return response
  }

  async fetchSettingsTypes ()
  {
    const service = new ServiceMain('settingsTypes/list')
    const response = await service.send()
    const result = response.data || []
    return result.map(o => ({ value: o.id, text: o.name }))
  }

  async fetchContests ()
  {
    const { data } = await serviceContests.fetchAll()
    const result = data || []
    return result.map(o => ({ value: o.id, text: o.name, company_id: o.company.id }))
  }

  async fetchCompanies ()
  {
    const { data } = await serviceCompanies.fetchAll()
    const result = data || []
    return result.map(o => ({ value: o.id, text: o.name }))
  }

}

export default ServiceSettings._getInstance()
