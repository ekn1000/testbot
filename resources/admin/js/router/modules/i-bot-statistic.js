import Layout from "@/admin/js/layout/index.vue";

const testbotStatisticRoutes = {
    name: 'testbotStatistic',
    path: '/i-bot-statistic',
    component: Layout,
    meta: { title: '',  noCache: false },
    redirect: '',
    children: [
        {
            name: 'testbotStatisticList',
            path:'',
            component: () => import('@/admin/js/views/testbot-statistic/index'),
            meta: {title: 'Статистика'}
        }

    ],
}
export default testbotStatisticRoutes;
