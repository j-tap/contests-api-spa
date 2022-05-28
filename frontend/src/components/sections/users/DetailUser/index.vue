<template>
  <dl class="row">
    <dt class="col-sm-3">E-mail</dt>
    <dd class="col-sm-9">{{ value.email }}</dd>
    <dt class="col-sm-3">Роль</dt>
    <dd class="col-sm-9">{{ value.role?.name }}</dd>
    <dt class="col-sm-3">Компании</dt>
    <dd class="col-sm-9">{{ companies }}</dd>
    <dt class="col-sm-3">Проведено розыгрышей</dt>
    <dd class="col-sm-9">{{ value.statistic?.contest_count }}</dd>
    <dt class="col-sm-3">Сгенерировано приглашений</dt>
    <dd class="col-sm-9">{{ value.statistic?.invites_count }}</dd>
    <dt class="col-sm-3">Зарегистрировано участников</dt>
    <dd class="col-sm-9">{{ value.statistic?.participants_count }}</dd>
  </dl>
</template>

<script>
export default {
  name: 'DetailUser',

  props: {
    value: {
      type: Object,
      default: () => {},
    },
  },

  computed: {
    companies ()
    {
      const list = this.value.companies || []
      return list.map(o => o.name).join(', ')
    },
  },
}
</script>
