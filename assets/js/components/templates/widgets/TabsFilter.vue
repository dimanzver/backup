<template>
    <ul class="nav nav-tabs">
        <li
            v-for="(text, key) in filtersObject"
            :key="key"
            class="nav-item"
        >
            <a class="nav-link"
               :class="{active: value == key && value !== null ||
                (key === 'null' && (value === null || value === undefined))}"
               href="#"
               @click.prevent="$emit('input', key)">
                {{text}}

                <button class="btn btn-link text-secondary d-inline-block ml-1"
                        v-if="showEdit"
                        @click.stop.prevent="$emit('edit', {key, text})"
                >&#9998;</button>

                <button class="btn btn-link text-danger d-inline-block"
                        v-if="showRemove"
                        @click.stop.prevent="$emit('remove', {key, text})"
                >&#10008;</button>
            </a>
        </li>
        <li v-if="showAdd" class="align-self-center">
            <button class="btn btn-primary ml-3" @click.stop.prevent="$emit('add')">{{addLabel}}</button>
        </li>
    </ul>
</template>

<script>
    export default {
        name: "TabsFilter",

        props: {
            filters: {
                required: true,
            },

            addLabel: {
                type: String,
                default: 'Добавить',
            },

            showAdd: {
              type: Boolean,
              default: false,
            },

            showRemove: {
              type: Boolean,
              default: false,
            },

            showEdit: {
              type: Boolean,
              default: false,
            },

            value: {},
        },

        computed: {
            //get object with key and value as text
            filtersObject(){
                if(!(this.filters instanceof Array))
                    return {...this.filters};

                let result = {};
                for(let filter of this.filters){
                    result[filter] = filter;
                }
                return result;
            },
        },
    }
</script>

<style scoped lang="scss">
    .nav-link{
        .btn-link{
            font-size: 1.5em;
        }

        &:hover{
            color: #495057 !important;
        }
    }
</style>