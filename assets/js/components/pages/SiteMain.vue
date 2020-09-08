<template>
    <div>
        <template v-if="site">
            <h1>Карточка сайта {{site.title}}</h1>

        </template>
    </div>
</template>

<script>
  import {mapGetters} from 'vuex';

  export default {
    name: 'SiteMain',

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