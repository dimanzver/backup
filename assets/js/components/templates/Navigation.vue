<template>
    <nav class="mb-4">
        <ul class="nav nav-pills">
            <li
                class="nav-item"
                v-for="(link, key) in links"
                :key="key"
            >
                <router-link active-class="active"
                             class="nav-link"
                             :to="link.to"
                >{{link.title}}</router-link>
            </li>
        </ul>
    </nav>
</template>

<script>
  export default {
    name: 'Navigation',

    data() {
      return {
        links: [
          {
            to: {name: 'main'},
            title: 'Главная',
          }
        ],
      };
    },

    methods: {

    },
  };
</script>

<style scoped lang="scss">

    .cabinet-navigation-wrap{
        width: 100%;
    }

    .cabinet-navigation-overlay{
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        background: rgba(0, 0, 0, .4);
        z-index: 999;
    }

    .cabinet-navbar{
        padding: 0;
    }

    .navbar-toggler{
        margin: .5em auto;
    }

    .cabinet-navigation {
        display: block;
        list-style: none;
        padding: 0;
        margin: 0;
        /*border-radius: .8em;*/
        overflow: hidden;
        align-self: flex-start;
        box-shadow: 5px 5px 5px #eee;
        width: 100%;
    }

    .cabinet-nav__link {
        a {
            display: block;
            padding: .5em 1em;
            /*font-size: 1.4em;*/
            color: #000;
            font-weight: normal;
            border-bottom: 1px #dedede solid;

            &:hover{
                text-decoration: none;
                background: #fc9f5b;
                color: #fff;
            }

            &.active {
                background: #a2acd9;
                color: #fff;
            }
        }
    }

    .nav-close{
        display: none;
    }

    @media (max-width: 1023px) {
        .navbar-toggler--main{
            margin: auto;
            margin-left: 0;
            padding: 1em;
            background: #6377d0;
            border: none;
            position: fixed;
            z-index: 99999;
            top: 0;
            left: 0;
            border-radius: 0 0 10px 0;

            .navbar-toggler-icon{
                filter: invert(1);
            }
        }

    }

    @media (max-width: 992px) {
        .cabinet-navigation-cont{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999999;
            height: 100vh;
            overflow: auto;
            transition: transform .3s;
            transform: translateX(-100%);
        }

        .nav-close{
            width: 240px;
            display: block;
            border: none;
            color: white;
            margin: 0;
            padding: .5em;
            background: #8c9be0;
            border-radius: 0;
            position: sticky;
            top: 0;

            &:before{
                content: '×';
                font-size: 2em;
                font-weight: normal;
                opacity: .8;
            }
        }


        .cabinet-navigation{
            box-shadow: none;
            min-height: calc(100vh - 3.75em);
            display: flex;
            flex-direction: column;

            &:after{
                content: '';
                flex: 150px 1 0;
                width: 240px;
                background: #fff;
            }
        }

        .cabinet-nav__link{
            background: #fff;
            width: 240px;
        }

        .cabinet-navigation-wrap{
            &.show{
                .cabinet-navigation-cont{
                    transform: none;
                }

                .cabinet-navigation-overlay{
                    display: block;
                }
            }
        }
    }

    @media (min-width: 1024px) {
        .mobile-link{
            display: none;
        }
    }
</style>