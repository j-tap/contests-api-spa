import Datetime from '@/libs/datetime'
import ServiceMain from './ServiceMain'
import store from '@/store'

class ServiceSystem
{
  static _instance

  static _getInstance ()
  {
    return ServiceSystem._instance || (ServiceSystem._instance = new ServiceSystem())
  }

  async getLog ()
  {
    const service = new ServiceMain('system/log')
    const { data } = await service.send()
    return this.toTable(data)
  }

  toTable (list)
  {
    const result = { list: [] }

    result.header = [
      { key: 'index', title: '#' },
      { key: 'date', title: 'Дата' },
      { key: 'type', title: 'Тип' },
      { key: 'message', title: 'Сообщение' },
      { key: 'env', title: 'Окружение' },
    ]
    
    if (list.length)
    {
      result.list = list.map((o, i) =>
      {
        const _options = {}

        if (o.type === 'ERROR') _options.bg = 'danger'
        if (o.type === 'WARNING') _options.bg = 'warning'

        return {
          index: i+1,
          date: Datetime.visual(o.date),
          type: o.type,
          message: o.message,
          env: o.env,
          _options,
        }
      })
    }

    return result
  }

  async getTgStatus ()
  {
    const service = new ServiceMain('system/tgStatus')
    const response = await service.send()
    return response.data
  }

  async tgAuth (form)
  {
    const service = new ServiceMain('system/tgAuth', form)
    const response = await service.send((serviceForm) =>
    {
      const result = {}
      if (serviceForm.code)
      {
        result.code = serviceForm.code.value
      }
      return result
    })

    if (response.success)
    {
      const { code } = response
      const message = form ? 'Telegram привязан к системе' : 'Код отправлен в Telegram'
      store.dispatch('notify/add', { code, message })
    }

    return response
  }

  async tgLogout ()
  {
    const service = new ServiceMain('system/tgLogout')
    const { success, code } = await service.send()
    if (success)
    {
      const message = 'Telegram отвязан'
      store.dispatch('notify/add', { code, message })
    }
    return success
  }

}

export default ServiceSystem._getInstance()
