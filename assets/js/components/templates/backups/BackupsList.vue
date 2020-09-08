<template>
    <div>
        <p class="lead" v-if="!backups.length">Пока нет бэкапов</p>
        <div class="table-responsive" v-else>
            <table class="table">
                <thead>
                    <tr>
                        <th>Сайт</th>
                        <th>Время начала</th>
                        <th>Статус</th>
                        <th>Прогресс</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="backup in backups" :key="backup.id">
                        <td>{{backup.site.title}}</td>
                        <td>{{backup.created_at|formatToHumanDate}} {{backup.created_at|toTime}}</td>
                        <td>{{backup.statusText}}</td>
                        <td>{{backup.progress_text}}</td>
                        <td>
                            <button v-if="!backup.status"
                                    class="btn btn-primary"
                                    @click="stop(backup)"
                            >Прервать</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'BackupsList',

    props: {
      backups: {
        type: Array,
        required: true,
      },
    },


    methods: {
      stop(backup) {
        if(!confirm(`Прервать бэкап сайта ${backup.site.title}?`))
          return;
        apiRequest.post('/api/backups/stop/' + backup.id).then(() => {
          this.$store.dispatch('addSuccess', 'Запрос на остановку бэкапа принят');
        });
      },
    },
  };
</script>

<style scoped>

</style>