<template>
    <div>
        <h1>Настройки</h1>

        <form action="" @submit.prevent="saveSettings">
            <label class="form-group d-block">
                <span class="d-block mb-1">Способ загрузки файлов</span>
                <select v-model="settingsForm.uploadMethod" class="form-control">
                    <option value="google-drive">Google Drive</option>
                </select>
            </label>

            <label class="form-group d-block">
                <span class="d-block mb-1">Папка в облаке для загрузок</span>
                <input type="text" class="form-control" v-model="settingsForm.baseRemote">
            </label>

            <GoogleDriveAuth v-if="settingsForm.uploadMethod === 'google-drive'"></GoogleDriveAuth>

            <button class="btn btn-success btn-lg mt-3">Сохранить</button>
        </form>
    </div>
</template>

<script>
  import {mapState, mapActions} from 'vuex';
  import GoogleDriveAuth from '../templates/GoogleDriveAuth';

  export default {
    name: 'Settings',

    components: {
      GoogleDriveAuth,
    },

    data() {
      return {
        settingsForm: {
          uploadMethod: 'google-drive',
          baseRemote: 'backups',
        },
      };
    },

    computed: {
      ...mapState('settings', ['settings']),
    },

    methods: {
      ...mapActions('settings', ['save']),

      saveSettings() {
        this.$store.commit('SET_PROCESSING', true);
        this.save(this.settingsForm).finally(() => {
          this.$store.commit('SET_PROCESSING', false);
        });
      },
    },

    watch: {
      settings: {
        immediate: true,
        deep: true,
        handler(settings) {
          if(!settings)
            return;

          this.settingsForm = {
            ...this.settingsForm,
            ...settings,
          };
        },
      },
    },
  };
</script>

<style scoped>

</style>