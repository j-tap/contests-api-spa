export function sortDesc (name = 'id')
{
  return (a, b) =>
    {
      const v1 = `${a[name]}`.toLowerCase()
      const v2 = `${b[name]}`.toLowerCase()
      return v1 < v2 ? 1 : v1 > v2 ? -1 : 0
    }
}

export function sortAsc (name = 'id')
{
  return (a, b) =>
    {
      const v1 = `${a[name]}`.toLowerCase()
      const v2 = `${b[name]}`.toLowerCase()
      return v1 > v2 ? 1 : v1 < v2 ? -1 : 0
    }
}
