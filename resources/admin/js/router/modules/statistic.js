import Layout from "@/admin/js/layout/index.vue";

const statisticRoutes = {
    name: 'statistic',
    path: '/statistic',
    component: Layout,
    meta: { title: '',  noCache: false },
    redirect: '/statistic/tasks',
    children: [
        {
            name: 'tasks',
            path:'tasks',
            component: () => import('@/admin/js/views/statistic/index'),
            meta: {title: 'Статистика'}
        }

    ],
}
export default statisticRoutes;
