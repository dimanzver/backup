<template>
    <div>
        <h1>Список сайтов</h1>

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
</template>

<script>
  import {mapState} from 'vuex';

  export default {
    name: 'Main',

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