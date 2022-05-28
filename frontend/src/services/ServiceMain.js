import Api from '@/plugins/api'
import Validator from '@/plugins/validator'
import Response from '@/models/Response'
import store from '@/store'

export default class ServiceMain
{
  #validator = null
  name = null
  form = null

  constructor (serviceName = null, form = null)
  {
    if (serviceName && typeof serviceName === 'string' && serviceName.length)
    {
      this.form = form && Object.keys(form).length ? form : null
      this.name = serviceName
    }
    else
    {
      throw `Undefined required arguments 'serviceName' of class ServiceMain in /plugin/services/ServiceMain.js`
    }
  }

  validation ()
  {
    this.#validator = new Validator(this.form)
    this.#validator.validation()
    return this.#validator.check()
  }

  async send (request)
  {
    const result = new Response()
    let valid = this.form ? this.validation() : true

    if (valid)
    {
      const data = request ? request({ ...this.form }) : null
      const response = await this.sending(data)

      if (!response.errors)
      {
        response.errors = []
      }

      if (!response.success)
      {
        if (this.form)
        {
          this.#validator.setErrors(response.errors)
          response.errors = this.#validator.getErrors()
        }
        this.sddNotify(response)
      }

      result.set(response)
    }
    else
    {
      const errors = this.#validator.getErrors()
      const message = 'Ошибка валидации'

      this.sddNotify({ message })

      result.set({ errors })
    }

    return result
  }

  async sending (data)
  {
    store.dispatch('variables/setLoading')
    const response = await Api.send(this.name, data)
    store.dispatch('variables/setLoading', false)
    return response
  }

  sddNotify (response)
  {
    store.dispatch('notify/add', response)
  }
}
