<template>
    <div class="global-alerts">
        <transition-group name="slide-right" mode="out-in" class="cont">
            <div class="alert alert-dismissible"
                 :class="'alert-' + item.type"
                 role="alert"
                 v-for="(item, key) in alerts"
                 :key="key"
            >
                {{item.text}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click.prevent.stop="REMOVE_ALERT(key)">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </transition-group>
    </div>
</template>

<script>
  import {mapState, mapMutations} from 'vuex';

  export default {
    name: 'GlobalAlerts',

    computed: {
      ...mapState(['alerts']),
    },

    methods: {
      ...mapMutations(['CLEAR_ALERTS', 'REMOVE_ALERT']),
    },

    watch: {
      $route(){
        this.CLEAR_ALERTS();
      },
    },
  };
</script>

<style scoped lang="scss">
    .global-alerts{
        position: fixed;
        bottom: 1em;
        right: 0;
        max-height: 50vh;
        overflow: scroll;
        overflow-x: hidden;
        width: 100%;
        max-width: 600px;

        .cont{
            display: flex;
            flex-direction: column-reverse;
        }
    }

    .alert{
        margin: .5em 1em;
    }
</style>