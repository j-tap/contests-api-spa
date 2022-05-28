<template>
  <div class="d-md-flex justify-content-between align-items-center mb-2">
    <div class="row align-items-center">
      <div class="col-sm">
        <Select
          v-model="filter.careers.value"
          :parameters="filter.careers.parameters"
        />
      </div>
      <div class="col-sm">
        <Checkbox
          v-model="filter.participant_telegram.value"
          :parameters="filter.participant_telegram.parameters"
        />
      </div>
    </div>
    <div class="btn-group" role="group">
      <Btn @click="onClickCodes">Экспорт кодов</Btn>
      <Btn @click="onClickToCsv">Экспорт в csv</Btn>
    </div>
  </div>

  <Table :value="participants">
    <template v-slot:column-comment="{ item }">
      <div class="d-flex align-items-start">
        <Btn
          class="me-2"
          size="sm"
          @click="modalParticipant.show({ item })"
        >&#128394;</Btn>
        <span v-text="item.comment"/>
      </div>
    </template>
  </Table>

  <Modal
    v-model="modalParticipant.display"
    :title="modalParticipant.title"
  >
    <Input
      v-model="modalParticipant.form.comment.value"
      :parameters="modalParticipant.form.comment.parameters"
    />
    <Btn @click="updateParticipant">Сохранить</Btn>
  </Modal>
</template>

<script>
import { sortDesc } from '@/libs/helpers/sort'
import Table from '@/components/ui/Table'
import Btn from '@/components/ui/Btn'
import Select from '@/components/ui/Select'
import Checkbox from '@/components/ui/Checkbox'
import Modal from '@/components/ui/Modal'
import Input from '@/components/ui/Input'

export default {
  name: 'TableWithFilter',

  components: {
    Table,
    Btn,
    Select,
    Checkbox,
    Modal,
    Input,
  },

  props: {
    value: {
      type: Object,
      default: () => ({}),
    },
    careers: {
      type: Array,
      default: () => [],
    },
  },

  emits: [
    'submit:table-form-contest-paticipant',
    'click:table-export-code',
    'click:table-export-csv',
  ],

  data() {
    return {
      filterModel: {
        careers: {
          value: false,
          parameters: {
            label: 'Сферы деятельности',
            items: [],
            multiple: true,
          },
        },
        participant_telegram: {
          value: 0,
          parameters: {
            label: 'Только участники канала',
          },
        },
        getValues ()
        {
          const result = {}
          Object.keys(this).forEach(k =>
          {
            if (this[k].value !== undefined)
            {
              result[k] = this[k].value
            }
          })
          return result
        },
      },
      modalParticipant: {
        display: false,
        item: {},
        title: null,
        form: {
          comment: {
            value: null,
            parameters: {
              label: 'Комментарий',
            },
          },
        },
        show ({ item = {}, display = true })
        {
          this.item = item
          this.title = `Участник розыгрыша ${item.name}`
          this.form.comment.value = item.comment
          this.display = display
        },
      },
    }
  },

  computed: {
    participants ()
    {
      const { filter } = this
      const participants = this.value
      const result = {}

      if (participants.list)
      {
        Object.assign(result, participants)
        result.list = this.filterParticipants(result.list, filter.getValues())
        result.list = this.formatParticipants(result.list)
      }
      return result
    },

    filter ()
    {
      const result = { ...this.filterModel }
      result.careers.parameters.items = this.careers
        .map(o => ({ text: o.text, value: o.text }))
      return result
    },
  },

  methods: {
    formatParticipants (list)
    {
      return list
        .map((o, i) =>
        {
          const index = i+1
          const participant_telegram = o.participant_telegram ? 'Да' : 'Нет'
          const winner = o.winner ? `${o.winner} Победитель` : '-'
          const _options = {}

          if (o.winner)
          {
            _options.bg = 'success'

            _options.col = {
              winner: { class: 'text-nowrap' }
            }
          }

          const row = { index, ...o, participant_telegram, winner, _options }

          delete row.id

          return row
        })
        .sort(sortDesc('winner'))
    },

    filterParticipants (list, filter)
    {
      return list.filter(item =>
      {
        let passed = true
        Object.keys(filter).forEach(k =>
        {
          switch (k)
          {
            case 'careers':
              if (filter[k] && filter[k].length && !filter[k].includes(item.career))
              {
                passed = false
              }
              break
            case 'participant_telegram':
              if (filter[k] && !item[k])
              {
                passed = false
              }
              break
            default:
              if (item[k] !== filter[k])
              {
                passed = false
              }
              break
          }
        })
        return passed
      })
    },

    onClickToCsv ()
    {
      const { list, header } = this.participants
      const data = { header }
      data.list = list.map(o =>
      {
        delete o._options
        return {
          ...o,
          comment: o.comment || '-'
        }
      })
      this.$emit('click:table-export-csv', data)
    },

    onClickCodes ()
    {
      const data = this.value.list ? this.value.list.map(o => o.code) : []
      this.$emit('click:table-export-code', data)
    },

    async updateParticipant ()
    {
      const { code } = this.modalParticipant.item
      let id = this.value.list.filter(o => o.code === code)[0].id
      const form = { ...this.modalParticipant.form }

      this.$emit('submit:table-form-contest-paticipant', { id, form })
      this.modalParticipant.show({ display: false })
    },
  },
}
</script>
