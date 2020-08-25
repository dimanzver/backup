<template>
    <div class="modal__overlay"
         @click="$emit('close')">
        <transition name="scale-fade" appear>
            <div class="modal__content"
                 :class="{withBg: withBg}"
                 @click.stop="">
                <slot></slot>
            </div>
        </transition>

        <div class="modal__close" v-if="closable" @click.stop="$emit('close')"></div>
    </div>
</template>

<script>
  export default {
    name: 'ModalWindow',

    props: {
      closable: {
        type: Boolean,
        default: true,
      },

      withBg: {
        type: Boolean,
        default: true,
      },
    },
  };
</script>

<style scoped lang="less">
    .modal {
        &__overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, .5);
            padding-top: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 100;
        }

        &__close {
            position: fixed;
            top: 30px;
            right: 15px;
            cursor: pointer;
            color: #fff;
            width: 60px;
            height: 60px;
            background: url('../../../../img/close.svg') no-repeat;
            background-size: contain;
            filter: invert(100%);

            &:hover {
                opacity: .7;
            }
        }

        &__content {
            padding: 1em;
            border-radius: 5px;
            max-height: calc(100vh - 70px);
            width: 100%;
            max-width: 1000px;

            &.withBg{
                background-color: #fff;
                box-shadow: 0 0 10px 2px #ccc;
            }
        }
    }
</style>