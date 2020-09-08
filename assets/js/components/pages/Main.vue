<template>
    <div>
        <div class="card mt-3">
            <div class="card-header">
                Список сайтов
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li v-for="site in sites"
                        :key="site.id"
                        class="list-group-item site-item"
                    >
                        <span>{{site.title}}</span>
                        <router-link :to="{
                  name: 'site.main',
                  params: {id: site.id},
                }">К сайту</router-link>
                    </li>
                </ul>
            </div>
        </div>

        <ActiveBackups></ActiveBackups>
        <FinishedBackups></FinishedBackups>
        <AbortedBackups></AbortedBackups>
    </div>
</template>

<script>
  import {mapState} from 'vuex';
  import ActiveBackups from '../templates/backups/ActiveBackups';
  import FinishedBackups from '../templates/backups/FinishedBackups';
  import AbortedBackups from '../templates/backups/AbortedBackups';

  export default {
    name: 'Main',

    components: {
      ActiveBackups, FinishedBackups, AbortedBackups,
    },

    computed: {
      ...mapState('sites', ['sites']),
    },
  };
</script>

<style scoped>
    .site-item{
        display: flex;
        justify-content: space-between;
    }
</style>