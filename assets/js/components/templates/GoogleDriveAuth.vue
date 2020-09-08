<template>
    <div>
        <template v-if="googleAuthStatus">
            <h2>Авторизация в Google</h2>

            <p v-if="googleAuthStatus.status">Вы уже авторизованы</p>
            <div v-else>
                <p>
                    Для авторизации перейдите по
                    <a :href="googleAuthStatus.authUrl" target="_blank">ссылке</a> и введите полученный код авторизации
                </p>

                <div class="form-group form-inline">
                    <label for="auth-code">Код авторизации</label>
                    <input type="text"
                           class="form-control ml-2 mr-2 flex-grow-1"
                           id="auth-code"
                           v-model="authCode"
                    >

                    <button class="btn btn-primary" @click.prevent="sendAuthCode">Отправить код</button>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
  export default {
    name: 'GoogleDriveAuth',

    data() {
      return {
        googleAuthStatus: null,
        authCode: '',
      };
    },

    created() {
      this.checkGoogleAuth();
    },

    methods: {
      checkGoogleAuth(){
        apiRequest.get('/api/google-drive/check-auth').then(googleAuthStatus => {
          this.googleAuthStatus = googleAuthStatus;
        });
      },

      sendAuthCode(){
        apiRequest.post('/api/google-drive/auth', {
          authCode: this.authCode,
        }).then( () => {
          this.checkGoogleAuth();
        }).catch(() => {
          alert('Ошибка авторизации');
        });
      },
    },
  };
</script>

<style scoped>

</style>