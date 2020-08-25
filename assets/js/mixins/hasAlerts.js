import AlertsBlock from '../components/templates/widgets/AlertsBlock';

export default {
  data() {
    return {
      successes: [],
      errors: [],
    };
  },

  components: {
    AlertsBlock,
  },

  methods: {
    clearMessages() {
      this.successes = [];
      this.errors = [];
    },
  },
};
