<template>
    <ListCard :removable="false" label="Прерванные бэкапы">
        <BackupsList :backups="backups"></BackupsList>
    </ListCard>
</template>

<script>
  import {mapGetters} from 'vuex';
  import BackupsList from './BackupsList';
  import ListCard from '../widgets/ListCard';

  export default {
    name: 'ActiveBackups',

    components: {
      BackupsList, ListCard,
    },

    props: {
      siteId: {},
    },

    computed: {
      ...mapGetters('backups', ['abortedBackups']),

      backups() {
        if(!this.siteId)
          return this.abortedBackups;

        return this.abortedBackups.filter(backup => {
          return parseInt(backup.site_id) === parseInt(this.siteId);
        });
      },
    },
  };
</script>

<style scoped>

</style>