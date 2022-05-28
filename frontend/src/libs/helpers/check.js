/**
 * Проверка на объект
 * @param value
 * @returns {Boolean}
 */
export function isObject (value)
{
  return (value && typeof value === 'object' && !Array.isArray(value))
}
