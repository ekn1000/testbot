<template>
    <div class="login-container">

        <el-form  :model="registerForm"  class="login-form" auto-complete="on" label-position="left">
            <h3 class="title">
                Регистрация
            </h3>
            <el-form-item prop="email" :error="errors.get('email')">
                <span class="svg-container">
                 <i class="el-icon-user"></i>
                </span>
                <el-input v-model="registerForm.email" name="email" type="text" auto-complete="on" :placeholder="$t('login.email')" />
            </el-form-item>

            <el-form-item prop="telegram">
                <span class="svg-container">
                 <svg width="20" height="20" viewBox="0 0 20 20">
                    <use xlink:href="/assets/admin/images/sprites.svg#sprite-telegram"></use>
                </svg>
                </span>
                <el-input v-model="registerForm.telegram" name="telegram" type="text"
                          auto-complete="on" placeholder="Telegram" />
            </el-form-item>
        <el-form-item prop="password" :error="errors.get('password')">
                <span class="svg-container" >
                 <i class="el-icon-lock"></i>
                </span>
                <el-input
                    v-model="registerForm.password"
                    :type="pwdType"
                    name="password"
                    auto-complete="on"
                    placeholder="Пароль"

                />
                <span class="show-pwd" @click="showPwd">
                </span>
            </el-form-item>
            <el-form-item prop="password_confirmation">
                <span class="svg-container" >
                 <i class="el-icon-lock"></i>
                </span>
                <el-input
                    v-model="registerForm.password_confirmation"
                    :type="pwdType"
                    name="password"
                    auto-complete="on"
                    placeholder="Подтвердите пароль"

                />
                <span class="show-pwd" @click="showPwd">
                </span>
            </el-form-item>
            <el-form-item prop="partner_code">
                <span class="svg-container">
                 <svg width="20" height="20" viewBox="0 0 20 20">
                    <use xlink:href="/assets/admin/images/sprites.svg?ver=1#sprite-referrals"></use>
                </svg>
                </span>
                <el-input v-model="registerForm.partner_code" name="partner_code" type="text"
                          auto-complete="on" placeholder="Код инвайта" />
            </el-form-item>
            <div class="d-flex justify-content-between align-items-center">
                <el-button style="padding-left: 50px;
                    padding-right: 50px;
                    text-transform: uppercase"
                    :loading="loading"
                    type="primary"
                    @click.native.prevent="handleLogin">
                    Регистрация
                </el-button>

                <a href="/admin/login" class="auth-link">Войти</a>
            </div>

        </el-form>
    </div>
</template>

<script>


import { csrf } from '@/admin/js/api/auth';
import { Errors } from  '@/common/js/services/errors.js';
export default {
    name: 'Login',

    data() {

        return {
            registerForm: {
                email: '',
                password: '',
                password_confirmation: '',
                telegram:"",
                partner_code: "",
            },

            loading: false,
            pwdType: 'password',
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
        showPwd() {
            if (this.pwdType === 'password') {
                this.pwdType = '';
            } else {
                this.pwdType = 'password';
            }
        },
        handleLogin() {
            csrf().then(() => {
                this.$store.dispatch('user/register', this.registerForm)
                    .then(() => {
                        this.$router.push({ path: this.redirect || '/', query: this.otherQuery }, onAbort => {});
                        this.loading = false;
                    })
                    .catch((error) => {
                        this.errors.record(error.response.data.errors);
                        this.loading = false;
                    });
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
        margin-left: 15px;
        display: inline-flex;
        color: $dark_gray;
        vertical-align: middle;
        width: 30px;
        align-items: center;
        justify-content: center;
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
