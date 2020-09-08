<template>
    <div>
        <template v-if="site">
            <h1>Карточка сайта {{site.title}}</h1>
            <p>Директория {{site.dir}}</p>

            <button class="btn btn-lg btn-primary" @click="startBackup">Начать бэкап</button>

            <ActiveBackups :site-id="id"></ActiveBackups>
            <FinishedBackups :site-id="id"></FinishedBackups>
            <AbortedBackups :site-id="id"></AbortedBackups>
        </template>
    </div>
</template>

<script>
  import {mapGetters} from 'vuex';
  import ActiveBackups from '../templates/backups/ActiveBackups';
  import FinishedBackups from '../templates/backups/FinishedBackups';
  import AbortedBackups from '../templates/backups/AbortedBackups';

  export default {
    name: 'SiteMain',

    components: {
      ActiveBackups, FinishedBackups, AbortedBackups,
    },

    props: {
      id: {
        required: true,
      },
    },

    computed: {
      ...mapGetters('sites', ['getById']),

      site() {
        return this.getById(this.id);
      },
    },

    methods: {
      startBackup() {
        apiRequest.post('/api/backups/start/' + this.id)
            .then(() => {
                this.$store.dispatch('addSuccess', 'Задача резервного копирования поставлена в очередь');
            });
      },
    },

    watch: {
      site: {
        immediate: true,
        handler(site) {
          if(site) {
            document.title = `${site.title} | Карточка сайта | Бэкапы`;
          }
        },
      },
    },
  };
</script>

<style scoped>

</style>