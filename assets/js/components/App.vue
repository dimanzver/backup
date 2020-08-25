<template>
    <div class="container-fluid">
        <transition name="fade" mode="out-in">
            <div v-if="$store.getters['auth/isAuthenticated']">
                <Navigation></Navigation>
                <div class="cabinet-container">
                    <div class="cabinet-content">
                        <transition name="slide" mode="out-in">
                            <keep-alive>
                                <router-view/>
                            </keep-alive>
                        </transition>
                    </div>
                </div>

                <GlobalAlerts></GlobalAlerts>
            </div>

            <Login v-else></Login>
        </transition>
    </div>
</template>

<script>
  import Navigation from './templates/Navigation';
  import GlobalAlerts from './templates/widgets/GlobalAlerts';
  import Login from './templates/Login';

  export default {
    name: 'App',

    components: {
      Navigation, GlobalAlerts, Login,
    },

    created() {

    },

    methods: {

    },
  };
</script>

<style scoped lang="scss">

</style>