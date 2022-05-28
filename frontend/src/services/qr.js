import ServiceMain from './ServiceMain'

class ServiceQr
{
  static _instance

  static number_color = 0

  static _getInstance ()
  {
    return ServiceQr._instance || (ServiceQr._instance = new ServiceQr())
  }

  async getQr (id)
  {
    const { number_color } = this
    const service = new ServiceMain('qr')
    const response = await service.send(() =>
    {
      return { id, number_color }
    })

    if (response.success)
    {
      this.number_color = response.data.number_color
    }
    return response
  }
}

export default ServiceQr._getInstance()

