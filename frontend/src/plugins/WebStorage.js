class WebStorage
{
  set (key, value)
  {
    const val = JSON.stringify(value)
    localStorage.setItem(key, val)
  }

  get (key)
  {
    let data = localStorage.getItem(key)

    try {
      data = JSON.parse(data);
    }
    catch (e)
    {
      console.error(e)
    }

    return data
  }

  delete (key)
  {
    localStorage.removeItem(key)
  }

  clean ()
  {
    localStorage.clear()
  }

}

export default new WebStorage()
