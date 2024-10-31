<template>
        <el-form :model="form" ref="form" label-position="top">
            <el-form-item prop="name" label="Название группы проектов" :error="errors.get('name')">
                <el-input v-model="form.name" placeholder="Название группы проектов"></el-input>
            </el-form-item>
            <el-form-item prop="comment" label="Комментарий" :error="errors.get('comment')">
                <el-input type="textarea" v-model="form.comment" placeholder="Комментарий"></el-input>
            </el-form-item>
            <div class="text-center">
                <el-button type="success" @click.prevent="save">Сохранить</el-button>
                <el-button  @click.prevent="closeModal">Отменить</el-button>
            </div>
        </el-form>

</template>
<script>
import { Errors } from  '@/common/js/services/errors.js';
export default {
    props:{
        saveMsg: {
            default: 'Группа проектов добавлена'
        },
        form: {
            type:Object
        },
        formAction: {
            type:Object
        }
    },
    data() {
        return {

            errors: new Errors(),
        }
    },
    methods: {

        closeModal(data) {
            this.$emit('close', data);
        },
        save() {
            axios({
                method: this.formAction.method ,
                url: this.formAction.url,
                data: this.form
            }).then((response) => {
                this.$message({
                    message: this.saveMsg,
                    type: 'success'
                });
                this.closeModal();
            })
                .catch((error) => {
                    this.errors.record(error.response.data.errors);
                })
            ;

        },
    },
    mounted() {

    }
}
</script>
