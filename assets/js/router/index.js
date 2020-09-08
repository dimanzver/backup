import Router from 'vue-router';
import Vue from 'vue';

Vue.use(Router);

const Main = () => import('../components/pages/Main');
const SiteMain = () => import('../components/pages/SiteMain');
const Settings = () => import('../components/pages/Settings');

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
    {
      path: '/sites/:id',
      name: 'site.main',
      component: SiteMain,

      meta: {
        title: 'Карточка сайта',
      },
      props: true,
    },
    {
      path: '/settings',
      name: 'settings',
      component: Settings,

      meta: {
        title: 'Настройки',
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
