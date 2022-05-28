import { isObject } from '@/libs/helpers/check'

/**
 * Глубокое объединение объектов
 * @param {Object} target
 * @param {Object} sources
 * @returns {Object}
 */
export function mergeObjects (target, ...sources)
{
  if (!sources.length)
  {
    return target
  }

  const source = sources.shift()

  if (isObject(target) && isObject(source))
  {
    for (const key in source)
    {
      if (isObject(source[key]))
      {
        if (!target[key])
        {
          Object.assign(target, { [key]: {} })
        }
        mergeObjects(target[key], source[key])
      }
      else {
        Object.assign(target, { [key]: source[key] })
      }
    }
  }

  return mergeObjects(target, ...sources)
}

/**
 * Глубокое копирование объектов
 * @param {Object} value
 * @returns {Object}
 */
 export function nestedCopy (value)
 {
   return JSON.parse(JSON.stringify(value))
 }

/**
 * Строку в хеш
 * @param  {String} string
 * @returns {String}
 */
export function toHash (value)
{
  let result = 0
  let string = value

  if (isObject(value))
  {
    string = JSON.stringify(value)
  }

  string = string.toString()

  if (string.length)
  {
    for (let i = 0; i < string.length; i++)
    {
      const chr = string.charCodeAt(i)
      result = ((result << 5) - result) + chr
      result |= 0 // Convert to 32bit integer
    }
  }

  return result
}

/**
 * Преобразование таблицы ({ header: [{}, ...], list: [{}, ...]}) в csv формат [[], [], ...]
 * @param  {Object} table
 * @returns {Array}
 */
export function tableToCsvFormat (table)
{
  const result = []
  const header = []

  table.header.forEach(o =>
  {
    header.push(o.title)
  })
  result.push(header)

  table.list.forEach(o =>
  {
    const row = []
    Object.keys(o).forEach(k =>
    {
      const val = `"${o[k]}"`
      row.push(val)
    })
    result.push(row)
  })

  return result
}
