/**
 * Скачивание файла
 * @param {Blob} file
 * @param {String} title
 * @returns {Object}
 */
export function fileDownload (file, name = null)
{
  const defaultName = new Date().toLocaleString()
  const ext = file.type.split(';')[0].split('/')[1]
  const filename = `${name || defaultName}.${ext}`
  const url = window.URL.createObjectURL(file)
  const link = document.createElement('a')

  link.href = url
  link.setAttribute('download', filename)

  document.body.appendChild(link)
  link.click()
}

/**
 * Создание csv файла
 * @param {Array} rows
 * @param {String} filename
 * @returns {Blob}
 */
export function createCsv (rows)
{
  const type = 'text/csv;charset=utf-8;'
  let csvContent = ''

  rows.forEach(rowArray =>
  {
    const row = rowArray.join(',')
    csvContent += `${row}\r\n`
  })

  const blob = new Blob([csvContent], { type })

  return blob
}
