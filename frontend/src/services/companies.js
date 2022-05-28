import { reactive } from 'vue'
import { sortAsc } from '@/libs/helpers/sort'
import store from '@/store'
import Service from './service'
import serviceContests from './contests'
import serviceSettings from './settings'
import { nestedCopy } from '@/libs/helpers/convertData'

class ServiceCompanies extends Service
{
  entitiesName = 'companies'
  entityName = 'company'

  state = reactive({
    companies: [],
    company: {},
  })

  static _instance

  static _getInstance ()
  {
    return ServiceCompanies._instance || (ServiceCompanies._instance = new ServiceCompanies())
  }

  getCompanies ()
  {
    return this.state.companies.sort(sortAsc('name'))
  }
  getCompany ()
  {
    const result = { ...this.state.company }

    if (result.contests)
    {
      const contests = nestedCopy(result.contests)
      result.contestsArchive = serviceContests.toArchive(contests)
      result.contests = contests.map(o =>
      {
        return serviceContests.toDefaultFormat(o)
      })
    }
    return result
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
      const message = 'Компания создана'
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

    return response
  }

  async deleteItem (id)
  {
    const response = await this.delete(id)

    if (response.success)
    {
      const { code } = response
      const message = 'Компания удалена'
      store.dispatch('notify/add', { code, message })
    }

    return response
  }

  async createContest (form)
  {
    const response = await serviceContests.createItem(form)
    if (response.success)
    {
      this.state.company.contests.push(response.data)
    }
    return response
  }

  async fetchLandingTemplates ()
  {
    return await serviceContests.fetchLandingTemplates()
  }

  async fetchStatuses ()
  {
    return await serviceContests.fetchStatuses()
  }

  async settingsUpdate (form)
  {
    const response = await serviceSettings.updateMultiple(form)
    if (response.success)
    {
      this.state.company.settings = response.data
    }
    return response
  }
}

export default ServiceCompanies._getInstance()
