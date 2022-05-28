export default class Validator
{
  #form = null
  // TODO: сделать валидацию на клиенте
  constructor (form = null)
  {
    if (form && typeof form === 'object' && Object.keys(form).length)
    {
      this.#form = form
    }
    else
    {
      throw `Undefined required arguments 'form' of class Validator in /plugin/validator/index.js`
    }
  }

  validation ()
  {
    return this.check()
  }

  check ()
  {
    return true
  }

  getErrors ()
  {
    const result = {}
    Object.keys(this.#form)
      .forEach(k =>
      {
        result[k] = this.#form[k].errors
      })
    return result
  }

  setErrors (errors)
  {
    Object.keys(this.#form)
      .forEach(k =>
      {
        this.#form[k].errors = errors[k] || []
      })
  }
}
