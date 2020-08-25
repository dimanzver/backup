import Router from 'vue-router';
import Vue from 'vue';

Vue.use(Router);

const Main = () => import('../components/pages/Main');

const router = new Router({
  // mode: 'history',
  routes: [
    {
      path: '/',
      name: 'main',
      component: Main,

      meta: {
        title: 'Главная',
      },
    },
  ],
});

router.beforeEach((to, from, next) => {
  const title = to.meta.title;
  if (title) {
    document.title = title +
      ' - Бэкапы';
  }

  next();
});

export default router;
