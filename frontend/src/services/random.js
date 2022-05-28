import Service from './service'
import ServiceMain from './ServiceMain'
import store from '@/store'

class ServiceRandom extends Service
{
  static _instance

  static _getInstance ()
  {
    return ServiceRandom._instance || (ServiceRandom._instance = new ServiceRandom())
  }

  async getParticipants (id)
  {
    const service = new ServiceMain('contests/participants')
    const response = await service.send(() =>
    {
      return { id }
    })

    if (response.success)
    {
      response.data = response.data.map(o => ({
        id: o.id,
        email: o.email,
        name: o.name,
        code: o.meta?.code,
        telegram: o.meta?.telegram,
        career: o.meta?.career,
        winner: o.meta?.winner,
        participant_telegram: o.meta?.participant_telegram,
      }))
    }
    else {
      store.dispatch('notify/add', response)
    }
    return response
  }

  async setWinner (id)
  {
    const service = new ServiceMain('users/winner')
    const response = await service.send(() =>
    {
      return { id }
    })
    return response
  }

}

export default ServiceRandom._getInstance()
