export default {
  namespaced: true,

  state: {
    settings: {},
  },

  mutations: {
    UPDATE_INFO(state, settings) {
      state.settings = settings;
    },
  },

  actions: {
    async load({commit}) {
      let settings = await apiRequest.get('/api/settings');
      commit('UPDATE_INFO', settings);
      return settings;
    },

    async save({commit}, data) {
      let settings = await apiRequest.post('/api/settings/save', {
        settings: data,
      });
      commit('UPDATE_INFO', settings);
      return settings;
    },
  },
};