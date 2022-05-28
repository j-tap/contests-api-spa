class Datetime
{
  static locale = 'ru-RU'
  static _instance

  static _getInstance ()
  {
    return Datetime._instance || (Datetime._instance = new Datetime())
  }

  date (value)
  {
    const date = this.toDate(value)
    const d = this.toTwoDigits(date.getDate())
    const m = this.toTwoDigits(date.getMonth())
    const y = date.getFullYear()
    return `${d}-${m}-${y}`
  }

  visual (value)
  {
    const options = {
      hour: 'numeric',
      minute: 'numeric',
      month: 'long',
      day: 'numeric',
    }
    const date = this.toDate(value)
    const isCurrentYear = this.isCurrentYear(date)

    if (!isCurrentYear)
    {
      options.year = 'numeric'
    }

    return date.toLocaleDateString(this.locale, options)
  }

  getVisual (value)
  {
    const d = this.toDate(value)
    const hours = d.toLocaleTimeString(this.locale, { hour: '2-digit' })
    const minutes = d.toLocaleTimeString(this.locale, { minute: '2-digit' })
    const seconds = d.toLocaleTimeString(this.locale, { second: '2-digit' })
    const year = d.toLocaleDateString(this.locale, { year: 'numeric' })
    const month = d.toLocaleDateString(this.locale, { month: 'long' })
    const date = d.toLocaleDateString(this.locale, { day: 'numeric' })

    return {
      hours,
      minutes,
      seconds,
      year,
      month,
      date,
    }
  }

  toDate (value)
  {
    return value instanceof Date ? value : new Date(value)
  }

  getNow ()
  {
    return new Date()
  }

  isCurrentYear (value)
  {
    const now = this.getNow()
    const date = this.toDate(value)
    return (parseInt(now.getFullYear()) === parseInt(date.getFullYear()))
  }

  toTwoDigits (value)
  {
    return (`0${(value + 1)}`).slice(-2)
  }
}

export default Datetime._getInstance()
