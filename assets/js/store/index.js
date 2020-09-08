import Vuex from 'vuex';
import Vue from 'vue';
Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

import auth from './modules/auth';
import sites from './modules/sites';
import settings from './modules/settings';
import backups from './modules/backups';

export default new Vuex.Store({
  modules: {
    auth, sites, settings, backups,
  },
  strict: debug,

  state: {
    processing: false,
    alerts: {},
  },

  mutations: {
    SET_PROCESSING(state, processing) {
      state.processing = processing;
    },

    ADD_ALERT(state, alert) {
      const key = new Date().getTime() + '_' + Math.random();
      state.alerts = {
        ...state.alerts,
        [key]: alert,
      };
    },

    REMOVE_ALERT(state, index) {
      const alerts = {...state.alerts};
      delete alerts[index];
      state.alerts = alerts;
    },

    CLEAR_ALERTS(state) {
      state.alerts = [];
    },
  },

  actions: {
    addSuccess({commit}, text) {
      const alert = {
        text,
        type: 'success',
      };
      commit('ADD_ALERT', alert);
    },

    addDanger({commit}, text) {
      const alert = {
        text,
        type: 'danger',
      };
      commit('ADD_ALERT', alert);
    },

  },
})
