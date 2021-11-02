<template>
    <div class="container">
        <div class="form-group">
            <input type="text" @blur="saveName" v-model="name" class="form-control"
                   :class="{ 'is-invalid': $v.name.$error }">
            <div class="invalid-feedback" v-if="!$v.name.required">
                Обязательное поле
            </div>
            <div class="invalid-feedback" v-if="!$v.name.maxLength">
                Максимальное количество символов {{ $v.name.$params.maxLength.max }}
            </div>
        </div>


        <div class="alert alert-danger" role="alert" v-if="errored">
            Ошибка загрузки данных!
        </div>
        <div class="text-center m-3" v-if="loading">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Загрузка...</span>
            </div>
        </div>
    </div>
</template>

<script>
import {required, maxLength} from 'vuelidate/lib/validators'

export default {
    props: [
        'deskId'
    ],
    data() {
        return {
            name: null,
            loading: true,
            errored: false
        }
    },
    methods: {
        saveName() {
            this.$v.name.$touch()
            if (this.$v.name.$anyError) {
                return;
            }
            axios.put('/api/v1/desks/' + this.deskId, {
                name: this.name,
            })
                .then(response => {

                })
                .catch(error => {
                    this.errored = true
                    console.log(error)
                })
                .finally(() => {
                    this.loading = false
                })
        }
    },
    mounted() {
        axios.get('/api/v1/desks/' + this.deskId)
            .then(response => {
                this.name = response.data.data.name;
            })
            .catch(error => {
                this.errored = true
                console.log(error)
            })
            .finally(() => {
                this.loading = false
            })
    },
    validations: {
        name: {
            required,
            maxLength: maxLength(255)
        }
    }

}
</script>
