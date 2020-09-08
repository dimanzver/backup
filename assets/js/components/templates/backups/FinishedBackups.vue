<template>
    <ListCard :removable="false" label="Завершенные бэкапы">
        <BackupsList :backups="backups"></BackupsList>
    </ListCard>
</template>

<script>
  import {mapGetters} from 'vuex';
  import BackupsList from './BackupsList';
  import ListCard from '../widgets/ListCard';

  export default {
    name: 'FinishedBackups',

    components: {
      BackupsList, ListCard,
    },

    props: {
      siteId: {},
    },

    computed: {
      ...mapGetters('backups', ['finishedBackups']),

      backups() {
        if(!this.siteId)
          return this.finishedBackups;

        return this.finishedBackups.filter(backup => {
          return parseInt(backup.site_id) === parseInt(this.siteId);
        });
      },
    },
  };
</script>

<style scoped>

</style>