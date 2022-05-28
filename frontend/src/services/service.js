import store from '@/store'
import ServiceMain from './ServiceMain'

class Service
{

  async index ()
  {
    const service = new ServiceMain(`${this.entitiesName}/list`)
    const response = await service.send()

    this.state[this.entitiesName] = response.data || []
    return response
  }

  async show (id)
  {
    const service = new ServiceMain(`${this.entitiesName}/get`)
    const response = await service.send(() =>
    {
      return { id }
    })
    if (!response.success)
    {
      store.dispatch('notify/add', response)
    }
    this.state[this.entityName] = response.data || {}
    return response
  }

  async create (form, request)
  {
    const service = new ServiceMain(`${this.entitiesName}/create`, form)
    const response = await service.send(request)

    if (response.success)
    {
      const data = response.data || {}
      this.state[this.entitiesName].push(data)
    }

    return response
  }

  async update (form, request)
  {
    const service = new ServiceMain(`${this.entitiesName}/update`, form)
    const response = await service.send(request)

    if (response.success)
    {
      const index = this.state[this.entitiesName].findIndex(o => o.id === form.id)
      if (index >= 0)
      {
        this.state[this.entitiesName][index] = response.data
      }
      this.state[this.entityName] = response.data || {}
    }

    return response
  }

  async delete (id)
  {
    const service = new ServiceMain(`${this.entitiesName}/delete`)
    const response = await service.send(() =>
    {
      return { id }
    })

    if (response.success)
    {
      const index = this.state[this.entitiesName].findIndex(o => o.id === id)
      if (index >= 0)
      {
        this.state[this.entitiesName].splice(index, 1)
      }
    }
    else {
      store.dispatch('notify/add', response)
    }

    return response
  }
}

export default Service
