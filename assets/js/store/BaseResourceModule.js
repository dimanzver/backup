export default {
  namespaced: true,

  state: {
    items: [],
    loaded: false,
    baseApiUrl: '',
    collectionName: 'items',
  },

  getters: {
    groupedIdsObject: state => {
      const result = {};
      state[state.collectionName].forEach(item => {
        result[item.id] = item;
      });
      return result;
    },

    findById: state => id => {
      return state[state.collectionName]
          .findIndex(item => parseInt(item.id) === parseInt(id));
    },
    getById: (state, getters) => id => {
      return getters.groupedIdsObject[id];
      // return state[state.collectionName]
      //     .find(item => parseInt(item.id) === parseInt(id));
    },
    totalCount: state => state[state.collectionName].length,
    paginate: state => (params = {}) => {
      const {page, perPage} = {
        page: 1,
        perPage: 15,
        ...params,
      };
      const startIndex = perPage * (page - 1);
      const all = params.forceItems ?
                params.forceItems :
                state[state.collectionName];
      const items = all.slice(startIndex, startIndex + perPage);

      const total = all.length;
      const pagesCount = Math.ceil(total / perPage);
      const from = items.length ? startIndex + 1 : 0;
      const to = items.length ? startIndex + items.length : 0;
      return {
        items, from, to, pagesCount, currentPage: page, total,
      };
    },
  },

  // TODO: vuex changes without mutations?
  mutations: {
    UPDATE_INFO(state, items) {
      state[state.collectionName] = items;
    },
    SET_LOADED(state, loaded) {
      state.loaded = loaded;
    },
    ADD(state, item) {
      const result = state[state.collectionName].slice();
      result.push(item);
      state[state.collectionName] = result;
    },
    REMOVE(state, index) {
      const result = state[state.collectionName].slice();
      result.splice(index, 1);
      state[state.collectionName] = result;
    },
    UPDATE(state, {index, item}) {
      const result = state[state.collectionName].slice();
      result[index] = item;
      state[state.collectionName] = result;
    },
  },

  actions: {
    async updateInfo({state, commit}, force = false) {
      if (state.loaded && !force) {
        return;
      }
      const items = await apiRequest.get(state.baseApiUrl);
      commit('UPDATE_INFO', items);
      commit('SET_LOADED', true);
    },

    async add({commit, state}, item) {
      commit('SET_PROCESSING', true, {root: true});
      const resultItem = await apiRequest.post(state.baseApiUrl, item);
      commit('SET_PROCESSING', false, {root: true});
      commit('ADD', resultItem);
      return resultItem;
    },

    async remove({commit, getters, state}, id) {
      commit('SET_PROCESSING', true, {root: true});
      await apiRequest.delete(state.baseApiUrl + '/' + id);
      commit('SET_PROCESSING', false, {root: true});
      const index = getters.findById(id);
      if (index >= 0) {
        commit('REMOVE', index);
      }
    },

    async update({commit, getters, state}, item) {
      commit('SET_PROCESSING', true, {root: true});

      const id = getItemId(item);
      const data = setQueryMethod(item, 'PATCH');

      const resultItem = await apiRequest
          .post(state.baseApiUrl + '/' + id, data);

      commit('SET_PROCESSING', false, {root: true});
      const index = getters.findById(id);
      if (index >= 0) {
        commit('UPDATE', {
          index,
          item: resultItem,
        });
      }
      return resultItem;
    },

    async save({dispatch}, item) {
      const id = getItemId(item);
      if (id) {
        return await dispatch('update', item);
      }

      return await dispatch('add', item);
    },
  },
}

function setQueryMethod(item, method) {
  if (item instanceof FormData) {
    item.set('_method', method);
  } else {
    item._method = method;
  }
  return item;
}

function getItemId(item) {
  if (item instanceof FormData) {
    return item.get('id');
  }
  return item.id;
}
