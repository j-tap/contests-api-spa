import { reactive } from 'vue'
import ServiceMain from './ServiceMain'
import store from '@/store'
import Service from './service'
import serviceSettings from './settings'
import Datetime from '@/libs/datetime'
import { tableToCsvFormat } from '@/libs/helpers/convertData'
import { createCsv, fileDownload } from '@/libs/helpers/files'

class ServiceContests extends Service
{
  entitiesName = 'contests'
  entityName = 'contest'

  state = reactive({
    contests: [],
    contest: {},
  })

  static _instance

  static _getInstance ()
  {
    return ServiceContests._instance || (ServiceContests._instance = new ServiceContests())
  }

  getContests ()
  {
    return this.state.contests.map(o => {
      return this.toDefaultFormat(o)
    })
  }
  getContest ()
  {
    const { contest } = this.state
    const result = this.toDefaultFormat(contest)
    result.participants = this.toTable(result.participants)
    return result
  }

  async fetchAll ()
  {
    return await this.index()
  }

  async fetchItem (id)
  {
    return await this.show(id)
  }

  async createItem (form)
  {
    const response = await this.create(form, (serviceForm) =>
    {
      const active = serviceForm.active.value
      const name = serviceForm.name.value
      const landing_template_id = serviceForm.landing_template_id.value
      const date_from = serviceForm.date_from.value
      const date_to = serviceForm.date_to.value
      const company_id = serviceForm.company_id.value
      return { name, active, landing_template_id, company_id, date_from, date_to }
    })

    if (response.success)
    {
      const { code } = response
      const message = 'Розыгрыш создан'
      store.dispatch('notify/add', { code, message })
    }

    return response
  }

  async updateItem (id, form)
  {
    const response = await this.update(form, (serviceForm) =>
    {
      const active = serviceForm.active.value
      const status_id = serviceForm.status_id.value
      const name = serviceForm.name.value
      const landing_template_id = serviceForm.landing_template_id.value
      const date_from = serviceForm.date_from.value
      const date_to = serviceForm.date_to.value
      return { id, name, active, status_id, landing_template_id, date_from, date_to }
    })

    return response
  }

  async deleteItem (id)
  {
    const response = await this.delete(id)

    if (response.success)
    {
      const { code } = response
      const message = 'Розыгрыш удалён'
      store.dispatch('notify/add', { code, message })
    }

    return response
  }

  async settingsUpdate (form)
  {
    const response = await serviceSettings.updateMultiple(form)
    if (response.success)
    {
      this.state.contest.settings = response.data
    }
    return response
  }

  async updateParticipant (id, form)
  {
    const service = new ServiceMain('users/participant', form)
    const response = await service.send((serviceForm) =>
    {
      const comment = serviceForm.comment.value
      return { comment, id }
    })
    if (response.success)
    {
      const index = this.state.contest.participants.findIndex(o => o.id === response.data.id)
      if (index >= 0)
      {
        this.state.contest.participants[index] = response.data
      }
    }

    return response
  }

  async fetchLandingTemplates ()
  {
    const service = new ServiceMain('templates/list')
    const response = await service.send()
    const result = response.data || []
    return result.map(o => ({ value: o.id, text: o.name }))
  }

  async fetchCareers ()
  {
    const service = new ServiceMain('careers/list')
    const response = await service.send()
    const result = response.data || []
    return result.map(o => ({ value: o.id, text: o.name }))
  }

  async fetchStatuses ()
  {
    const service = new ServiceMain('statuses/list')
    const response = await service.send()
    const result = response.data || []
    return result.map(o => ({ value: o.id, text: o.name }))
  }

  async exportCsv (table)
  {
    const rowsArray = tableToCsvFormat(table)
    const fileBlob = createCsv(rowsArray)
    fileDownload(fileBlob)
  }

  toDefaultFormat (item)
  {
    const result = { ...item }

    if (result.date)
    {
      if (result.date.from) result.date.from_visual = Datetime.visual(result.date.from)
      if (result.date.to) result.date.to_visual = Datetime.visual(result.date.to)
    }

    if (result.participants)
    {
      result.participants = result.participants.map(o =>
      {
        const meta = {
          ...o.meta,
          created_at_qr_visual: Datetime.visual(o.created_at),
        }
        return {
          ...o,
          meta,
          created_at_visual: Datetime.visual(o.created_at),
        }
      })
    }

    return result
  }

  toArchive (list)
  {
    let result = {}

    if (list)
    {
      list.forEach(o =>
      {
        if (o.status && o.status.id !== 1)
        {
          const dateFrom = new Date(o.date.from || 0)
          const dateVisual = Datetime.getVisual(dateFrom)
          const keyYear = dateFrom.getFullYear()
          const titleYear = dateVisual.year
          const keyMonth = dateFrom.getMonth()
          const titleMonth = dateVisual.month
          const item = this.toDefaultFormat(o)

          if (!result[keyYear])
          {
            result[keyYear] = {
              title: titleYear,
              list: {},
            }
          }

          if (!result[keyYear].list[keyMonth])
          {
            result[keyYear].list[keyMonth] = {
              title: titleMonth,
              list: [],
            }
          }

          result[keyYear].list[keyMonth].list.push(item)
        }
      })
    }
    return result
  }

  toTable (list)
  {
    const result = { list: [] }

    result.header = [
      { key: 'index', title: '#' },
      { key: 'code', title: 'Код' },
      { key: 'name', title: 'Имя' },
      { key: 'email', title: 'E-mail' },
      { key: 'telegram', title: 'Telegram' },
      { key: 'participant_telegram', title: 'Участник канала' },
      { key: 'career', title: 'Род деятельности' },
      { key: 'manager', title: 'Менеджер' },
      { key: 'winner', title: 'Победитель' },
      { key: 'comment', title: 'Комментарий' },
      { key: 'created_at_qr', title: 'Время генерации QR' },
      { key: 'created_at', title: 'Время регистрации' },
    ]
    
    if (list)
    {
      result.list = list.map(o =>
      {
        return {
          id: o.id,
          code: o.meta?.code,
          name: o.name,
          email: o.email,
          telegram: o.meta?.telegram,
          participant_telegram: o.meta?.participant_telegram,
          career: o.meta?.career,
          manager: o.meta?.manager.name,
          winner: o.meta && o.meta.winner ? o.meta.order_winner : null,
          comment: o.meta?.comment,
          created_at_qr: o.meta?.created_at_qr_visual,
          created_at: o.created_at_visual,
        }
      })
    }

    return result
  }
}

export default ServiceContests._getInstance()
