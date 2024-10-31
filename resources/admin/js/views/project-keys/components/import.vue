<template>

    <section class="import-tasks row align-items-center mb-4">
        <div class=" col-md-7 col-xl-5">
            <label class="upload-file" :class="{'upload-file--error': errors.has('file')}">
                <input class="upload-file__input"
                       @change="uploadFile"
                       type="file"
                       ref="file">
                <span class="upload-file__btn el-button upload-file__btn el-button--primary el-button--medium">
                    <i class="el-icon-document"></i>
                    <span>
                          Выберите файл
                    </span>
                </span>
                <span class="upload-file__text">
                       {{fileName}}
                </span>
                <span class="upload-file__error" v-if="errors.has('file')">
                    {{errors.get('file')}}
                </span>
            </label>
        </div>
        <div class="col-md-5">
            <el-button icon="el-icon-upload" type="success" @click="ImportFile">
                Импортировать
            </el-button>
            <el-button icon="el-icon-close" @click="clearUploadFile">
                Очистить
            </el-button>
        </div>
        <el-dialog
            :visible.sync="modalVisible"
            width="80%"
            title="Импорт завершен"
            v-if="modalVisible"
        >
        <h4 style="color:#67C23A">Добавили </h4>
        <ul class="import-list">
            <li class="import-list__item" v-for="item in successArr">
                {{item}}
            </li>
        </ul>
        <h4 style="color:#F56C6C">Не Добавили </h4>
            <ul class="import-list">
                <li class="import-list__item" v-for="item in failArr">
                    {{item}}
                </li>
            </ul>
            <span slot="footer" class="dialog-footer">
            <el-button type="primary" @click="modalVisible = false">Закрыть</el-button>
             </span>
        </el-dialog>
    </section>
</template>
<script>
import { Errors } from  '@/common/js/services/errors.js';
    export default {
        computed: {
            fileName: function () {
                let name = "Файл не выбран";
                if(this.file && this.file.name) {
                    name = this.file.name;
                }
               return name;
            }
        },
        data() {
            return {
                file:"",
                errors: new Errors(),
                failArr: [],
                successArr: [],
                modalVisible:false,
            }
        },
        methods: {
            uploadFile() {
                this.file = this.$refs.file.files[0];

            },
            ImportFile() {
                const formData = new FormData();
                formData.append('file', this.file);
                formData.append('project_id', this.$route.params.project_id);
                const headers = { 'Content-Type': 'multipart/form-data' };
                axios.post('/api/admin/project-key/import',formData, {headers})
                    .then((response) => {
                        this.errors.clear();
                        this.successArr = response.data.successArr;
                        this.failArr = response.data.failArr;
                        this.modalVisible = true;
                        this.$emit('imported');
                    })
                    .catch((error) => {
                        this.errors.record(error.response.data.errors);
                    })
            },
            clearUploadFile() {
                this.file = "";
                this.$refs.file.value=null;
                this.errors.clear();
            }
        }
    }
</script>
