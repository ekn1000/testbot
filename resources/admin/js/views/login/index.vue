<template>
  <div class="login-container">
      <el-form ref="loginForm" :model="loginForm"

               class="login-form"
               auto-complete="on"
               label-position="left">
          <h3 class="title">
               Войти в панель управления
          </h3>
          <el-form-item prop="token"
                        :error="errors.get('token')"
          >
       <span class="svg-container">
         <i class="el-icon-lock"></i>
        </span>
          <el-input v-model="loginForm.token"
                    name="token"
                    type="text"
                    auto-complete="on"
                    placeholder="токен из телеграм бота" />
          </el-form-item>

          <div class="d-flex justify-content-center align-items-center">
              <el-button style="padding-left: 50px;
                padding-right: 50px;
                width: 100%;
                text-transform: uppercase"
                :loading="loading" type="primary"
                @click.native.prevent="handleLogin">
                  Войти
              </el-button>


          </div>

      </el-form>
  </div>
</template>

<script>
import { Errors } from  '@/common/js/services/errors.js';
import { validEmail } from '@/admin/js/utils/validate';
import { csrf } from '@/admin/js/api/auth';

export default {
  name: 'Login',

  data() {

    return {
      loginForm: {
        token: '',
      },
      loginRules: {
          token: [{ required: true, trigger: 'blur',}],

      },
      loading: false,
      redirect: undefined,
      otherQuery: {},
      errors: new Errors(),
    };
  },
  watch: {
    $route: {
      handler: function(route) {
        const query = route.query;
        if (query) {
          this.redirect = query.redirect;
          this.otherQuery = this.getOtherQuery(query);
        }
      },
      immediate: true,
    },
  },
  methods: {

    handleLogin() {
      this.$refs.loginForm.validate(valid => {
        if (valid) {
          this.loading = true;
          csrf().then(() => {
            this.$store.dispatch('user/login', this.loginForm)
              .then(() => {
                this.$router.push({ path: this.redirect || '/', query: this.otherQuery }, onAbort => {});
                this.loading = false;
                console.log(this.otherQuery)
              })
              .catch((error) => {
                this.errors.record(error.response.data.errors);
                this.loading = false;
              });
          });
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    getOtherQuery(query) {
      return Object.keys(query).reduce((acc, cur) => {
        if (cur !== 'redirect') {
          acc[cur] = query[cur];
        }
        return acc;
      }, {});
    },
  },
};
</script>

<style rel="stylesheet/scss" lang="scss">
$bg:#2d3a4b;
$light_gray:#eee;

/* reset element-ui css */
.login-container {
  .el-input {
    display: inline-block;
    height: 47px;
    width: 85%;
    input {
      background: transparent;
      border: 0px;
      -webkit-appearance: none;
      border-radius: 0px;
      padding: 12px 5px 12px 15px;
      color: $light_gray;
      height: 47px;
      &:-webkit-autofill {
        -webkit-box-shadow: 0 0 0px 1000px $bg inset !important;
        -webkit-text-fill-color: #fff !important;
      }
    }
  }
  .el-form-item {
    border: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    color: #454545;
  }
}
.auth-link {
    color: #fff;
    text-transform: uppercase;
    font-size: 16px;
    text-decoration: none;
}
</style>

<style rel="stylesheet/scss" lang="scss" scoped>
$bg:#2d3a4b;
$dark_gray:#889aa4;
$light_gray:#eee;
.login-container {
  position: fixed;
  height: 100%;
  width: 100%;
  background-color: $bg;
  .login-form {
    position: absolute;
    left: 0;
    right: 0;
    width: 520px;
    max-width: 100%;
    padding: 35px 35px 15px 35px;
    margin: 120px auto;
  }
  .tips {
    font-size: 14px;
    color: #fff;
    margin-bottom: 10px;
    span {
      &:first-of-type {
        margin-right: 16px;
      }
    }
  }

  .svg-container {
    padding: 6px 5px 6px 15px;
    color: $dark_gray;
    vertical-align: middle;
    width: 30px;
    display: inline-block;
  }
  .title {
    font-size: 26px;
    color: $light_gray;
    margin: 0px auto 40px auto;
    text-align: center;
    font-weight: bold;
  }
  .show-pwd {
    position: absolute;
    right: 10px;
    top: 7px;
    font-size: 16px;
    color: $dark_gray;
    cursor: pointer;
    user-select: none;
  }
  .set-language {
    color: #fff;
    position: absolute;
    top: 40px;
    right: 35px;
  }
}
@media screen and (orientation:landscape) and (max-width:1024px) {
  .login-container {
    position: relative;
    overflow-y: auto;
    .login-form {
      transform: translate(-50%, -50%);
      left: 50%;
      top: 50%;
      margin: auto;
    }
  }
}
</style>
