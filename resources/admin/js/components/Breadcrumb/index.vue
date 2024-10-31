<template>
    <section>
        <el-breadcrumb class="app-breadcrumb" separator="/">
            <transition-group name="breadcrumb">
                <el-breadcrumb-item v-for="(item, index) in levelList" :key="item.path">
        <span v-if="item.redirect==='noredirect'||index==levelList.length-1" class="no-redirect">
          {{ generateTitle(item.meta.title) }}
        </span>
                    <a v-else @click.prevent="handleLink(item)">{{ generateTitle(item.meta.title) }}</a>
                </el-breadcrumb-item>
            </transition-group>
        </el-breadcrumb>
    </section>

</template>

<script>
import { generateTitle } from '@/admin/js/utils/i18n';
const pathToRegexp = require('path-to-regexp');

export default {
  name: 'Breadcrumb',
  data() {
    return {
      levelList: null,
    };
  },
  watch: {
    $route() {
      this.getBreadcrumb();
    },
  },
  created() {
    this.getBreadcrumb();
  },
    computed: {
        crumbs: function() {
            let pathArray = this.$route.path.split("/");

            //pathArray.shift()
            let breadcrumbs = pathArray.reduce((breadcrumbArray, path, idx) => {
                breadcrumbArray.push({
                    path: path,
                    to: breadcrumbArray[idx - 1]
                        ? "/" + breadcrumbArray[idx - 1].path + "/" + path
                        : "/" + path,
                    text: this.$route.matched[idx].meta.breadCrumb || path,
                });
                return breadcrumbArray;
            }, [])
            return breadcrumbs;
        }
    },
  methods: {
    generateTitle,
      async getBreadcrumbName(id, type, nameData) {
        return axios.get('/api/admin/breadcrumbs', {params: {id: id, type: type}} )
            .then((response) => {
               nameData(response.data)
            })
            .catch((error) => {
                console.log(error);
            })

      },
      async getBreadcrumb() {

        let pathArray = this.$route.path.split("/");
        pathArray.shift()

      let matched = this.$route.matched.filter(item => item.name);
        matched.forEach((item, index) => {
                console.log(index)
            if(item.name === 'ProjectGroup' || item.name === 'Project') {
                let id = pathArray[index];
                let type = item.name;
                let lst = [];
                const nameData = (data) => {lst.push(data)}

               this.getBreadcrumbName(id, type, nameData)
                   .then(() => {
                   matched[index+1].meta.title = lst[0];
                   });
            }
        })
      const first = matched[0];
      if (first && first.name.trim().toLocaleLowerCase() !== 'Dashboard'.toLocaleLowerCase()) {
        matched = [{ path: '/dashboard', meta: { title: 'dashboard' }}].concat(matched);
      }

      this.levelList = matched.filter(
        item => item.meta && item.meta.title && item.meta.breadcrumb !== false
      );
    },
    pathCompile(path) {
      const { params } = this.$route;
      var toPath = pathToRegexp.compile(path);

      return toPath(params);
    },
    handleLink(item) {
      const { redirect, path } = item;
        if(this.$route.fullPath !== redirect  && this.$route.fullPath !==path) {
            if (redirect) {
                this.$router.push(redirect);
                return;
            }
            this.$router.push(this.pathCompile(path));
        }
    },
  },
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.app-breadcrumb.el-breadcrumb {
  display: inline-block;
  font-size: 14px;
  line-height: 50px;
  margin-left: 20px;
  .no-redirect {
    color: #97a8be;
    cursor: text;
  }
}
</style>
