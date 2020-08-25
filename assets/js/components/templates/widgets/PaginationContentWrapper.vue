<template>
    <div>
        <PaginationParamsWrapper
            :pagination="pagination"
            :route="route"
            @move="$emit('move', $event)"
        ></PaginationParamsWrapper>

        <slot></slot>

        <PaginationParamsWrapper
            :pagination="pagination"
            :route="route"
            @move="$emit('move', $event)"
        ></PaginationParamsWrapper>
    </div>
</template>

<script>
    import PaginationParamsWrapper from './PaginationParamsWrapper';

    export default {
        name: "PaginationContentWrapper",

        components: {
            PaginationParamsWrapper
        },

        props: {
            pagination: {
                type: Object,
                required: true,
            },
            route: {
                type: Object,
            },
        },
    }
</script>

<style scoped>

</style>