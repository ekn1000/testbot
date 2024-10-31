import Layout from "@/admin/js/layout/index.vue";



const projectsRoutes = {
    name: 'project-groups',
    path: '/project-groups',
    component: Layout,
    meta: { title: 'Группы проектов',  noCache: false },
    redirect: '/project-groups/list',

    children: [
        {
            name: 'project-groups-list',
            path:'list',
            component: () => import('@/admin/js/views/project-groups/index'),
            meta: {title: ''}
        },
        {
            name:'ProjectGroup',
            path: ':id',
            component: () => import('@/admin/js/views/project-groups/show'),
            meta: { title:'Группа проектов',  noCache: true},
            children: [
                {
                    name: 'projects',
                    path: '',
                    component: () => import('@/admin/js/views/projects/index'),
                    meta: { title:'',  noCache: true},

                },
                {
                    name: 'Project',
                    path: ':project_id',
                    component: () => import('@/admin/js/views/projects/show'),
                    meta: { title:'Проект',  noCache: true},


                    children: [
                        {
                            name: 'keys',
                            path:"",
                            component: () => import('@/admin/js/views/project-keys/index'),
                            meta: { title:'',  noCache: true},

                        }
                    ]
                }
            ]
        }

    ],
}
export default projectsRoutes;
