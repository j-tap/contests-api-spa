import { mergeObjects, nestedCopy } from '@/libs/helpers/convertData'

export default {
  data() {
    return {
      nameEntity: null,
      formReset: {},
      formModel: {},
    }
  },

  computed: {
    form: {
      get ()
      {
        return mergeObjects(this.formModel, this.modelValue)
      },
      set (value)
      {
        this.updateValue(value)
      },
    },
  },

  created ()
  {
    this.updateValue(this.form)
    this.formReset = nestedCopy(this.formModel)
  },

  methods: {
    onSubmit ()
    {
      this.$emit(`submit:form-${this.nameEntity}`, this.form)
    },

    updateValue (value)
    {
      this.$emit('update:modelValue', value)
    },

    clearForm ()
    {
      const data = {}
      Object.keys(this.formReset)
        .forEach(k => data[k] = this.formReset[k].value)
      this.setValuesForm(data)
    },

    setValuesForm (data)
    {
      Object.keys(this.form).forEach(k =>
      {
        this.form[k].value = data[k]
      })
    },

  },
}
