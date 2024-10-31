<template>
<section>

    <el-form
        class="disabled-form"
        :model="form" label-position="top" :disabled="!checkRole(['admin'])">
        <div class="row">
            <el-form-item class="col-md-6" label="Имя" :error="errors.get('name')">
                <el-input v-model="form.name"></el-input>
            </el-form-item>
            <el-form-item class="col-md-6" label="Баланс">
                <el-input v-model="form.balance">
                    <template slot="append">руб.</template>
                </el-input>
            </el-form-item>
        </div>
        <div class="row">
            <el-form-item class="col-md-6" label="Telegram">
                <el-input v-model="form.tg_username">
                    <template slot="prepend">@</template>
                </el-input>
            </el-form-item>
            <el-form-item class="col-md-6" label="Telegram ID">
                <el-input v-model="form.telegram_id"></el-input>
            </el-form-item>
        </div>
        <div class="row">
            <el-form-item class="col-md-6" label="Telegram Имя">
                <el-input v-model="form.tg_first_name"></el-input>
            </el-form-item>
            <el-form-item class="col-md-6" label="Telegram Фамилия">
                <el-input v-model="form.tg_last_name"></el-input>
            </el-form-item>
        </div>
        <div class="row">
            <el-form-item class="col-md-8" label="Токен">
                <el-input v-model="form.token"></el-input>
            </el-form-item>
        </div>
        <div class="row">
            <el-form-item class="col-md-2" label="Реф. %">
                <el-input v-model="form.referral_percent"></el-input>
            </el-form-item>
            <el-form-item class="col-md-3" label="Приглашено рефералов">
                <el-input v-model="form.total_referrals"></el-input>
            </el-form-item>
            <el-form-item class="col-md-7" label="Ваша реф. ссылка" v-if="form.referral_url">
                <el-input v-model="form.referral_url"></el-input>
            </el-form-item>
        </div>
        <div class="row align-items-end">
            <el-form-item class="col-md-6" label="Телефон" v-if="checkRole(['admin'])">
                <el-input v-model="form.phone"></el-input>
            </el-form-item>
            <el-form-item class="col-md-6" label="Название компании" v-if="checkRole(['admin'])">
                <el-input v-model="form.company_name"></el-input>
            </el-form-item>
            <div class="col-md-6" style="margin-bottom: 22px;" v-if="checkRole(['admin'])">
                <el-button icon="el-icon-unlock" type="primary"
                           @click="showPasswordModal = true">Сменить пароль</el-button>
            </div>
        </div>
        <el-button type="success" @click="onSubmit" v-if="checkRole(['admin'])">Сохранить</el-button>
    </el-form>
    <el-dialog
        :visible.sync="showPasswordModal"
        title="Сменить пароль"
    >
        <el-form :model="passwordForm" label-position="top">
            <div class="row">
                <el-form-item class="col-md-6" label="Новый пароль" :error="errors.get('password')">
                    <el-input v-model="passwordForm.password" show-password></el-input>
                </el-form-item>
                <el-form-item class="col-md-6" label="Подтверждение пароля">
                    <el-input v-model="passwordForm.password_confirmation" show-password></el-input>
                </el-form-item>
            </div>
        </el-form>
        <span slot="footer" class="dialog-footer" >
            <el-button @click="showPasswordModal = false">Отмена</el-button>
            <el-button type="success" @click="changePassword">Сохранить</el-button>
          </span>
    </el-dialog>
</section>
</template>
<script>
import { Errors } from  '@/common/js/services/errors.js';
import {mapGetters} from "vuex";
import checkRole from '@/admin/js/utils/role';
export default {

    data() {
        return {
            showPasswordModal:false,
            passwordForm: {
                password: '',
                password_confirmation: ''
            },
            form: {
                name: "",
                email: "",
                telegram_id: "",
                tg_first_name:"",
                tg_last_name: "",
                tg_username: "",
                referral_percent: "",
                referral_token: "",
                referral_url: "",
                total_referrals: "",
                company_name: "",
                balance: 0,
                phone: "",
                token: ""
            },
            errors: new Errors(),
        }
    },
    computed: {
        ...mapGetters([
            'userId',
        ]),
    },
    methods: {
        checkRole,
        changePassword() {
            axios.post('/api/admin/user/' + this.userId + '/change-password', this.passwordForm)
                .then((response) => {
                    this.$message({
                        message: response.data,
                        type: 'success'
                    });
                    this.showPasswordModal = false;
                    this.passwordForm.password = '';
                    this.passwordForm.password_confirmation= '';
                })
                .catch((error) => {
                    this.errors.record(error.response.data.errors);
                })
        },
        onSubmit() {
            axios.post('/api/admin/user/' + this.userId + '/update', this.form)
                .then((response) => {
                    this.$store.commit('user/SET_NAME', response.data.name);
                    this.$message({
                        message: 'Ваши данные изменены',
                        type: 'success'
                    });
                })
                .catch((error) => {
                    this.errors.record(error.response.data.errors);
                })
        },
        getUser() {
            axios.get('/api/admin/user/' + this.userId + '/show')
                .then((response) => {
                    this.form = response.data;
                    this.form.referral_url = "https://t.me/TestBot?start=" + this.form.referral_token;
                })
        },
    },
    mounted() {
        this.getUser();
    }
}
</script>
