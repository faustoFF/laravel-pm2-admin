<template>
  <div class="p-3">
    <div>
      <h3 class="float-left">
        PM2 Admin
      </h3>
      <div class="float-right">
        <span v-if="updatedAt" class="text-muted">{{ updatedAt | moment('YYYY-MM-DD HH:mm:ss') }}</span>

        <b-button
            variant="secondary"
            @click="fetchList()"
        >
          <b-icon icon="arrow-repeat" />
        </b-button>
      </div>
      <div class="clearfix" />
      <hr>
    </div>

    <b-table
      :id="tableId"
      :items="items"
      :fields="fields"
      show-empty
      stacked="lg"
      empty-text="Пусто"
      head-variant="light"
      sort-by="name"
    >
      <template #[`cell(pm2_env.pm_uptime)`]="{ value }">
        <span
          v-b-tooltip.hover
          :title="value | moment('YYYY-MM-DD HH:mm:ss')"
        >{{ new Date().getTime() - value | duration('humanize') }}
        </span>
      </template>

      <template #[`cell(pm2_env.restart_time)`]="{ value }">
        <span
          :class="{'text-muted': value === 0}"
          v-text="value"
        />
      </template>

      <template #[`cell(pm2_env.status)`]="{ value }">
        <b-badge
          :variant="statusBadgeVariant(value)"
          v-text="value"
        />
      </template>

      <template #[`cell(monit.cpu)`]="{ value }">
        {{ value }}%
      </template>

      <template #[`cell(monit.memory)`]="{ value }">
        {{ formatBytes(value) }}
      </template>

      <template #[`cell(pm2_env.created_at)`]="{ value }">
        {{ value | moment('YYYY-MM-DD HH:mm:ss') }}
      </template>

      <template #cell(actions)="{ item }">
        <b-button
          v-if="item.pm2_env.status === 'online'"
          v-b-tooltip.hover
          class="mr-1 mb-1"
          title="Перезапустить"
          variant="warning"
          @click="restart(item.name)"
        >
          <b-icon icon="arrow-repeat" />
        </b-button>

        <b-button
          v-if="item.pm2_env.status !== 'stopped'"
          v-b-tooltip.hover
          class="mr-1 mb-1"
          title="Остановить"
          variant="danger"
          @click="stop(item.name)"
        >
          <b-icon icon="stop-circle" />
        </b-button>

        <b-button
          v-if="item.pm2_env.status === 'stopped'"
          v-b-tooltip.hover
          class="mr-1 mb-1"
          title="Запустить"
          variant="success"
          @click="start(item.name)"
        >
          <b-icon icon="play-circle" />
        </b-button>
      </template>
    </b-table>
  </div>
</template>

<script>
import Service from './Service'

export default {
  name: 'Admin',
  data () {
    return {
      tableId: 'pm2-table',
      items: [],
      updatedAt: undefined,
      fetchTimer: undefined,
      fields: [
        { key: 'name', label: 'Name', sortable: true },
        { key: 'pid', label: 'PID', sortable: true },
        { key: 'pm2_env.pm_uptime', label: 'Uptime', sortable: true },
        { key: 'pm2_env.restart_time', label: 'Restarts', sortable: true },
        { key: 'pm2_env.status', label: 'Status', sortable: true },
        { key: 'monit.cpu', label: 'Cpu', sortable: true },
        { key: 'monit.memory', label: 'Memory', sortable: true },
        { key: 'pm2_env.created_at', label: 'Created', sortable: true },
        { key: 'actions', label: '' }
      ]
    }
  },
  mounted () {
    this.fetchTimer = setInterval(() => this.fetchList(), 5 * 1000)

    this.fetchList()
  },
  methods: {
    fetchList () {
      Service.list()
        .then(response => {
          this.items = response.data
          this.updatedAt = new Date()
        })
    },
    restart (process) {
      Service.restart(process)
        .then(() => {
          window.pm2AdminApp.$bvToast.toast(`Процесс ${process} был перезапущен`, {
            title: 'Успех',
            variant: 'success'
          })
        })
    },
    stop (process) {
      Service.stop(process)
        .then(() => {
          window.pm2AdminApp.$bvToast.toast(`Процесс ${process} был остановлен`, {
            title: 'Успех',
            variant: 'success'
          })
        })
    },
    start (process) {
      Service.start(process)
        .then(() => {
          window.pm2AdminApp.$bvToast.toast(`Процесс ${process} был запущен`, {
            title: 'Успех',
            variant: 'success'
          })
        })
    },
    statusBadgeVariant (status) {
      switch (status) {
        case 'online':
          return 'success'

        case 'stopped':
          return 'danger'
      }
    },
    formatBytes (bytes, decimals = 2) {
      if (!+bytes) return '0 Bytes'

      const k = 1024
      const dm = decimals < 0 ? 0 : decimals
      const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']

      const i = Math.floor(Math.log(bytes) / Math.log(k))

      return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`
    }
  }
}
</script>
