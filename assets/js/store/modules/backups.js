import BaseResourceModule from '../BaseResourceModule';

export default {
  ...BaseResourceModule,
  state: {
    backups: [],
    loaded: false,
    baseApiUrl: '/api/backups',
    collectionName: 'backups',
    statuses: {
      PROCESSING: 0,
      ABORTED: 1,
      FINISHED: 2,
    },
  },

  getters: {
    activeBackups: state => {
      return state.backups.filter(backup => {
        return backup.status === state.statuses.PROCESSING;
      });
    },

    finishedBackups: state => {
      return state.backups.filter(backup => {
        return backup.status === state.statuses.FINISHED;
      });
    },

    abortedBackups: state => {
      return state.backups.filter(backup => {
        return backup.status === state.statuses.ABORTED;
      });
    },
  },
};
