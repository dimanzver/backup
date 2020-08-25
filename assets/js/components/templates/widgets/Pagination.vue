<template>
    <div>
        <template v-if="pagesCount > 1">
            <p>Показано {{from || 0}} - {{to || 0}} из {{total}}</p>
            <paginate
                    :value="currentPage"
                    :page-count="pagesCount"
                    :click-handler="clickCallback"
                    :prev-text="'<'"
                    :next-text="'>'"
                    :container-class="'pagination'"
                    :page-class="'page-item'"
                    :page-range="7"
                    page-link-class="page-link"
                    prev-class="page-item"
                    next-class="page-item"
                    prev-link-class="page-link"
                    next-link-class="page-link"
            ></paginate>
        </template>
    </div>

</template>

<script>
    import Paginate from 'vuejs-paginate'

    export default {
        name: "Pagination",

        components: {
            Paginate
        },

        props: {
            currentPage: {
                type: Number,
                required: true,
            },

            pagesCount: {
                type: Number,
                required: true,
            },

            from: {
                type: Number,
                default: 0,
            },

            to: {
                type: Number,
                default: 0,
            },

            total: {
                type: Number,
                required: true,
            },

            route: {
                type: Object,
            },
        },

        methods: {
            clickCallback(pageNum){
                if(this.route){
                  this.$router.push({name: this.route.name, params: {page: pageNum}});
                }else {
                  this.$emit('move', pageNum);
                }
            },
        },
    }
</script>

<style scoped lang="less">
    .pagination{
        flex-wrap: wrap;
    }
</style>