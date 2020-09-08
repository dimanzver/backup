<template>
    <div class="container-fluid">
        <transition name="fade" mode="out-in">
            <div v-if="$store.getters['auth/isAuthenticated']">
                <router-link class="btn btn-primary m-2" :to="{name: 'main'}">Главная</router-link>
                <router-link class="btn btn-primary m-2" :to="{name: 'settings'}">Настройки</router-link>
                <div class="cabinet-container">
                    <div class="cabinet-content">
                        <transition name="slide" mode="out-in">
<!--                            <keep-alive>-->
                                <router-view/>
<!--                            </keep-alive>-->
                        </transition>
                    </div>
                </div>

                <GlobalAlerts></GlobalAlerts>
            </div>

            <Login v-else></Login>
        </transition>

        <div class="processing-loader" v-if="$store.state.processing"></div>
    </div>
</template>

<script>
  import GlobalAlerts from './templates/widgets/GlobalAlerts';
  import Login from './templates/Login';

  export default {
    name: 'App',

    components: {
      GlobalAlerts, Login,
    },

    created() {
      this.$store.dispatch('sites/updateInfo');
      this.$store.dispatch('settings/load');
      this.$store.dispatch('backups/updateInfo');
      setInterval(() => {
        this.$store.dispatch('backups/updateInfo', true);
      }, 5000);
    },

    methods: {

    },
  };
</script>

<style scoped lang="scss">
    .processing-loader {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, .5);
        background-image: url(../../img/loader.svg);
        background-position: center;
        background-repeat: no-repeat;
        z-index: 100;
    }
</style>