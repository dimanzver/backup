<template>
    <Pagination
            :current-page="parseInt(pagination.currentPage)"
            :pages-count="parseInt(pagination.pagesCount)"
            :from="parseInt(pagination.from)"
            :to="parseInt(pagination.to)"
            :total="parseInt(pagination.total)"
            :route="route"
            @move="$emit('move', $event)"
    ></Pagination>
</template>

<script>
    import Pagination from './Pagination';

    export default {
        name: "PaginationParamsWrapper",

        components: {
            Pagination
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