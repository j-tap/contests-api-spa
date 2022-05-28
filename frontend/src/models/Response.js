export default class Response
{
  #defaultOptions = {
    data: null, 
    errors: null,
    message: null,
    success: false,
    code: null,
    timestamp: null,
  }

  constructor(options = {})
	{
    Object.assign(this, this.#defaultOptions)
		this.set(options)
  }

  set (options = {})
  {
    const replace = {}

    if (!(options instanceof Response))
    {
      replace.code = 'status'
    }

    Object.keys(this.#defaultOptions).forEach(key =>
			{
        const k = replace[key] || key
        if (options[k] !== undefined)
        {
          this[key] = options[k]
        }
			})
  }

}
