<template>
    <div class="login-container">
        <h1 class="text-center">Авторизация</h1>

        <form action="" @submit.prevent="login" class="mb-3">
            <label class="form-group d-block">
                <span class="d-block mb-1">Логин</span>
                <input type="text" class="form-control" v-model="form.login" required>
            </label>
            <label class="form-group d-block">
                <span class="d-block mb-1">Пароль</span>
                <input type="password" class="form-control" v-model="form.password" required>
            </label>

            <button class="btn btn-success">Войти</button>
        </form>

        <AlertsBlock v-model="errors" type="danger"></AlertsBlock>
    </div>
</template>

<script>
  import hasAlerts from '../../mixins/hasAlerts';
  import AlertsBlock from './widgets/AlertsBlock';

  export default {
    name: 'Login',

    components: {
      AlertsBlock,
    },

    data(){
      return {
        form: {
          login: '',
          password: '',
        },
      };
    },

    mixins: [hasAlerts],

    methods: {
      login(){
        this.$store.dispatch('auth/login', this.form)
            .catch(response => {
              ErrorProcessing.getErrorMessage(response).then(error => {
                this.errors = [error];
              });
            });
      },
    },
  };
</script>

<style scoped lang="scss">
    .login-container{
        margin: 0 auto;
        max-width: 500px;
    }


</style>