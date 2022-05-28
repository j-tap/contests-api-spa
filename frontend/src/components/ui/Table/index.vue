<template>
  <div class="scrollspy">
    <table class="table">
      <thead>
        <tr>
          <th
            v-for="item in headers"
            :key="`th-${item.key}`"
            scope="col"
          >{{ item.title }}</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(row, i1) in list"
          :key="`tr-${i1}`"
          :class="row.row_class"
        >
          <td
            v-for="(key, i2) in Object.keys(row).filter(n => !excludeColumns.includes(n))"
            :key="`td-${i2}`"
            :class="row.columns_classes[key]"
            scope="row"
          >
            <slot
              v-if="!!$slots[`column-${key}`]"
              :name="`column-${key}`"
              :item="row"
            />
            <span v-else v-html="row[key]"/>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
	name: 'Table',

  props: {
    value: {
      type: Object,
      default: () => ({ header: [], list: [] }),
    },
  },

  data() {
    return {
      excludeColumns: ['_options', 'row_class', 'columns_classes']
    }
  },

  computed: {
    headers()
    {
      const defaultHeader = this.value.length ? Object.keys(this.value[0]) : []
      return this.value.header && this.value.header.length ? this.value.header : defaultHeader
    },
    list ()
    {
      const list = this.value.list || []
      const result = list 
        .map(o =>
        {
          let row_class = ''
          let columns_classes = {}

          if (o._options)
          {
            if (o._options.bg)
            {
              row_class = `table-${o._options.bg}`
            }
            if (o._options.col)
            {
              Object.keys(o._options.col)
                .forEach(colName =>
                {
                  if (o._options.col[colName])
                  {
                    columns_classes[colName] = o._options.col[colName].class
                  }
                })
            }
          }

          return {
            ...o,
            row_class,
            columns_classes,
          }
        })

      return result
    },
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
