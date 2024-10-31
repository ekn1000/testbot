import Vue from 'vue';
import Router from 'vue-router';

/**
 * Layzloading will create many files and slow on compiling, so best not to use lazyloading on devlopment.
 * The syntax is lazyloading, but we convert to proper require() with babel-plugin-syntax-dynamic-import
 * @see https://doc.laravue.dev/guide/advanced/lazy-loading.html
 */

Vue.use(Router);

/* Layout */
import Layout from '@/admin/js/layout';


/* Router for modules */
import errorRoutes from './modules/error';
import projectsRoutes from "./modules/projects";
import statisticRoutes from "./modules/statistic";
import testbotStatistic from "./modules/i-bot-statistic";


export const constantRoutes = [
    {
        path: '/redirect',
        component: Layout,
        hidden: true,
        children: [
            {
                path: '/redirect/:path*',
                component: () => import('@/admin/js/views/redirect/index'),
            },
        ],
    },
    {
        path: '/login',
        component: () => import('@/admin/js/views/login/index'),
        hidden: true,
    },
    {
        path: '/admin-login',
        component: () => import('@/admin/js/views/admin-login/index'),
        hidden: true,
    },
    {
        path: '/register',
        component: () => import('@/admin/js/views/register/index'),
        hidden: true,
    },
    {
        path: '/auth-redirect',
        component: () => import('@/admin/js/views/login/AuthRedirect'),
        hidden: true,
    },

    {
        path: '/404',
        redirect: { name: 'Page404' },
        component: () => import('@/admin/js/views/error-page/404'),
        hidden: true,
    },
    {
        path: '/401',
        component: () => import('@/admin/js/views/error-page/401'),
        hidden: true,
    },




    //elementUiRoutes,
];


export const asyncRoutes = [
    {
        path: '/',
        component: Layout,
        redirect: 'profile',
        children: [
            {
                path: 'dashboard',
                redirect: 'profile',
                name: 'Dashboard',
                meta: { title: 'dashboard',  noCache: false },
            },
            {
                path: 'profile',
                component: () => import('@/admin/js/views/user-profile/index'),
                name: 'UserProfile',
                meta: {title: 'Профиль'},
            },
            {
                path:'users',
                component: () => import('@/admin/js/views/users/index'),
                name: 'Users',
                meta: { title: 'Пользователи',  noCache: false , permissions: ['manage_users']},
            },

        ],
    },
    projectsRoutes,
    statisticRoutes,
    testbotStatistic,
    errorRoutes,

    { path: '*', redirect: '/404', hidden: true },
];


const createRouter = () => new Router({
    mode: 'history', // require service support
    scrollBehavior: () => ({ y: 0 }),
    base: process.env.MIX_LARAVUE_PATH,
    routes: constantRoutes,
});

const router = createRouter();

// Detail see: https://github.com/vuejs/vue-router/issues/1234#issuecomment-357941465
export function resetRouter() {
    const newRouter = createRouter();
    router.matcher = newRouter.matcher; // reset router
}

export default router;
