import BaseResourceModule from '../BaseResourceModule';

export default {
  ...BaseResourceModule,
  state: {
    sites: [],
    loaded: false,
    baseApiUrl: '/api/sites',
    collectionName: 'sites',
  },
};
