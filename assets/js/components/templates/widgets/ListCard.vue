<template>
    <div class="card">
        <div class="card-header" :class="{'card-header--removable': removable}" @click.stop="toggleOpen">
            <div class="card-title">{{label}}</div>
            <button class="card-remove btn btn-link text-danger" v-if="removable" @click.stop.prevent="$emit('remove')">Удалить</button>
        </div>

        <div class="card-body" :class="{'hidden-block': !opened}">
            <slot></slot>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'ListCard',

    props: {
      label: {
        type: String,
        required: true,
      },

      removable: {
        type: Boolean,
        default: true,
      },

      opened: {
        type: Boolean,
        default: false,
      },
    },

    methods: {
      toggleOpen(e){
        let cartBody = e.target.closest('.card')
                        .querySelector('.card-body');
        $(cartBody).slideToggle();
      },
    },
  };
</script>

<style scoped lang="scss">
    .card{
        margin-top: 15px;
        margin-bottom: 15px;
    }

    .card-header--removable{
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .card-header{
        cursor: pointer;
        &:hover{
            background-color: #eee;
        }
    }

    .card-title{
        flex-wrap: 200px 1 0;
    }
</style>