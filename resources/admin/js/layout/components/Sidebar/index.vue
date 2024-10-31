<template>
    <aside class="main-sidebar"  ref="SidebarMenu" id="main_sidebar">
            <el-menu
                :router="true"
                class="sidebar-nav"
                :default-active="activeLink"
            >
                <perfect-scrollbar :style="{height: height + 'px'}">
                    <!--
                    <el-submenu index="/profile" >
                        <template slot="title" >
                            <i class="el-icon-user"></i>
                            <span class="sidebar-nav__link-text">Пользователь</span>
                        </template>
                        <el-menu-item index="/profile" >
                            <span class="sidebar-nav__link-text">Профиль</span>
                        </el-menu-item>
                    </el-submenu>
                    -->
                    <el-menu-item index="/profile" >
                        <i class="el-icon-user"></i>
                        <span class="sidebar-nav__link-text">Пользователь</span>
                    </el-menu-item>
                    <el-menu-item index="/i-bot-statistic" >
                        <i class="el-icon-cpu"></i>
                        <span class="sidebar-nav__link-text">Копии testbot</span>
                    </el-menu-item>
                    <el-menu-item index="/project-groups/list" >
                        <i class="el-icon-s-operation"></i>
                        <span class="sidebar-nav__link-text">Группы проектов</span>
                    </el-menu-item>
                    <el-menu-item index="/statistic/tasks" >
                        <i class="el-icon-s-data"></i>
                        <span class="sidebar-nav__link-text">Статистика</span>
                    </el-menu-item>
                    <el-menu-item index="/users" v-if="checkPermission(['manage_users'])">
                        <i class="el-icon-setting"></i>
                        <span class="sidebar-nav__link-text">Пользователи</span>
                    </el-menu-item>
                    <li class="el-menu-item" style="padding-left: 20px;" @click.prevent="copyUpdateStatisticUrl">
                        <i class="el-icon-copy-document"></i>
                        <span class="sidebar-nav__link-text">URL для статистики</span>
                    </li>
                    <li
                        v-if="referral_token"
                        class="el-menu-item" style="padding-left: 20px;"
                        @click.prevent="copyRefUrl">
                        <i class="el-icon-copy-document"></i>
                        <span class="sidebar-nav__link-text">Ваша реф. ссылка</span>
                    </li>
                </perfect-scrollbar>
            </el-menu>

        <input type="hidden" id="update_statistic_url" :value="updateStatisticUrl">
        <input type="hidden" id="ref_url" :value="refUrl">
    </aside>
</template>
<script>

import checkPermission from '@/admin/js/utils/permission';
import { PerfectScrollbar } from 'vue2-perfect-scrollbar'
import {mapGetters} from "vuex";
export default {
    components: { PerfectScrollbar },
    mounted(){
        const resize_ob = new ResizeObserver(() => {
            this.matchHeight();
        });
        resize_ob.observe(document.querySelector('#main_sidebar'));
        let match = _.chain(this.$route.matched).sortBy(n => n.path.length).last().value();
        this.activeLink = match.path;

    },
    computed:{
        ...mapGetters([
            'referral_token',
        ]),
    },

    methods: {
        checkPermission,
        copyUpdateStatisticUrl() {
            const url = window.location.protocol + '//' + window.location.host + '/api/update-task/?tid=[[TID]]&taskid=[[TASKID]]&date=[[FORMATTED_DATE]]&tasktype=[[TASKTYPE]]&targetdomain=[[TARGETDOMAIN]]&targeturl=[[TARGETURL]]&keyword=[[KEYWORD]]&position=[[POSITION]]&getparameters=[[GETPARAMETERS]]&projectname=[[PROJECTNAME]]&pid=[[PID]]&device=[[DEVICE]]&cookies=[[COOKIES]]&uniquedomains=[[UNIQUEDOMAINS]]&ymdomains=[[YMDOMAINS]]&gadomains=[[GADOMAINS]]&proxy=[[PROXY]]';
            let updateStatisticUrlInput = document.querySelector('#update_statistic_url');
            updateStatisticUrlInput.setAttribute('type', 'text');
            updateStatisticUrlInput.setAttribute('value', url);
            updateStatisticUrlInput.select()

            try {
                var successful = document.execCommand('copy');
                var msg = successful ? 'successful' : 'unsuccessful';
                this.$message({
                    type: 'success',
                    message: 'Ссылка для отправки статистики из скрипта в API скопирована'
                });
            } catch (err) {

            }

            /* unselect the range */
            updateStatisticUrlInput.setAttribute('type', 'hidden')
            window.getSelection().removeAllRanges()
        },
        copyRefUrl() {
            const url = 'https://t.me/TestBot?start=' + this.referral_token
            let refUrlInput = document.querySelector('#ref_url');
            refUrlInput.setAttribute('type', 'text');
            refUrlInput.setAttribute('value', url);
            refUrlInput.select()

            try {
                var successful = document.execCommand('copy');
                var msg = successful ? 'successful' : 'unsuccessful';
                this.$message({
                    type: 'success',
                    message: 'Реферальная ссылка скопирована'
                });
            } catch (err) {

            }

            /* unselect the range */
            updateStatisticUrlInput.setAttribute('type', 'hidden')
            window.getSelection().removeAllRanges()
        },
        matchHeight() {
            let height = this.$refs.SidebarMenu.clientHeight;

            this.height = height - 80;
        }
    },
    data(){
        return{
           height:0,
            updateStatisticUrl: '',
            refUrl: "",
            activeLink: null,
            menu:[


            ],
        }
    }
}
</script>
<style>
@import "vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css";

</style>

