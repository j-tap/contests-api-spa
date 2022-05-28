import Response from '@/models/Response'
import requests from '@/configs/requests'

class Api
{
  #axios = null
  #store = null
  #options = {
    baseURL: process.env.VUE_APP_API_URL || '',
    timeout: 60000,
    headers: {
      'Content-type': 'application/json',
    }
  }
  #requests = requests

  #getParameters (model, data)
  {
    const [ name, sub ] = model.split('/')
    let requestData = this.#requests[name]
    if (requestData)
    {
      if (sub)
      {
        requestData = requestData[sub]
      }
      return {
        ...requestData,
        data,
      }
    }
    throw `Undefined model name '${name}' in /plugin/api/requests.js`
  }

  #requestErrorHandler (error)
  {
    if (error && error.response)
    {
      let result = { ...error.response }
      return result
    }
    throw error
  }

  async #sendRequest (params)
  {
    const request = this.#axios.create(this.#options)
    request.interceptors.response.use((response) => response, this.#requestErrorHandler)
    return await request(params)
  }

  #updateHeaders ()
  {
    if (this.#store.getters['auth/loggedIn'])
    {
      const token = this.#store.getters['auth/token']
      this.#options.headers['Authorization'] = `Bearer ${token}`
    }
    else {
      delete this.#options.headers['Authorization']
    }
  }

  async send (model, dataRequest)
  {
    if (model)
    {
      this.#updateHeaders()

      const parameters = this.#getParameters(model, dataRequest)
      const { method, data } = parameters
      let { url } = parameters

      if (url.includes(':'))
      {
        const r = /:\w+/g
        const params = url.match(r) /* example: [':id', ':name'] */
        params.forEach(param =>
        {
          const value = data[param.replace(':', '')]
          url = url.replace(param, value)
        })
      }

      const response = await this.#sendRequest({
        method,
        url,
        data,
      })

      return new Response(response.data)
    }
    else {
      throw `Undefined argument 'model' for method send(model)`
    }   
  }


  install ({ axios, config }, { store })
  {
    this.#axios = axios
    this.#store = store

    config.globalProperties.$api = (model, data) =>
    {
      return this.send(model, data)
    }
  }
}

export default new Api()
