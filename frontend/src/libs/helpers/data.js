/**
 * Получение темы клиента
 * @returns {String}
 */
export function getClientTheme ()
{
  return window.matchMedia
    && window.matchMedia('(prefers-color-scheme: dark)').matches
    ? 'dark' : 'light'
}
