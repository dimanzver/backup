<template>
    <ListCard :removable="false" class="mt-3" label="Текущие бэкапы">
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
      ...mapGetters('backups', ['activeBackups']),

      backups() {
        if(!this.siteId)
          return this.activeBackups;

        return this.activeBackups.filter(backup => {
          return parseInt(backup.site_id) === parseInt(this.siteId);
        });
      },
    },
  };
</script>

<style scoped>

</style>