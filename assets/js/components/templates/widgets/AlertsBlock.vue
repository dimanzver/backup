<template>
    <div>
        <transition v-for="(item, key) in value" :key="key" name="fade" appear>
            <div class="alert alert-dismissible"
                 :class="'alert-' + type"
                 role="alert"
            >
                {{item}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click.prevent.stop="hide(key)">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        name: "AlertsBlock",

        props: {
            value: {
                type: Array,
            },
            type: {
                type: String,
                required: true,
            },
        },

        methods: {
            hide(key){
                let value = this.value.slice();
                value.splice(key, 1);
                this.$emit('input', value);
            },
        },
    }
</script>

<style scoped>

</style>
