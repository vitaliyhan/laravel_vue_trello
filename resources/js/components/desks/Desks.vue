<template>
    <div class="container">
        <h1>Доски</h1>
        <form class="add_new" @submit.prevent="addNewDesk()">
            <div class="mb-3">
                <label class="form-label" for="name">Имя доски</label>
                <input id="name" v-model="name" :class="{ 'is-invalid': $v.name.$error }" aria-describedby="nameHelp"
                       class="form-control"
                       type="text">
                <div v-if="!$v.name.required" class="invalid-feedback">
                    Обязательное поле
                </div>
                <div v-if="!$v.name.maxLength" class="invalid-feedback">
                    Максимальное количество символов {{ $v.name.$params.maxLength.max }}
                </div>
            </div>

            <button class="btn btn-primary" type="submit">Добавить</button>
        </form>
        <div v-if="errored" class="alert alert-danger mt-3" role="alert">
            <span v-for="error of errors">Ошибка!<br>{{ error }}</span>
        </div>
        <div v-if="loading" class="text-center m-3">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Загрузка...</span>
            </div>
        </div>
        <div class="row">
            <div v-for="desk of desks" class="col-lg-4">
                <div class="card mt-3 text-center">
                    <router-link :to="{name: 'showDesk', params: {deskId:desk.id}}" class="card-body">
                        <h4 class="card-title">{{ desk.name }}</h4>
                    </router-link>
                    <div class="card-body">
                        <a class="btn btn-outline-danger" href="#" @click="deleteDesk(desk.id)"><i
                            class="bi bi-trash-fill"></i> Удалить</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import {required, maxLength} from 'vuelidate/lib/validators'

export default {
    name: "Desks",
    data() {
        return {
            desks: [],
            errored: false,
            errors: [],
            loading: true,
            name: null
        }
    },
    methods: {
        addNewDesk() {
            this.$v.name.$touch()
            if (this.$v.name.$anyError) {
                return;
            }
            this.errored = false

            axios.post('/api/v1/desks', {
                name: this.name,
            })
                .then(response => {
                    this.$v.$reset();
                    this.desks = []
                    this.name = null
                    this.getAllDesks();
                })
                .catch(error => {
                    this.errored = true
                    if (error.response.data.errors.name) {
                        this.errors = []
                        this.errors.push(error.response.data.errors.name[0])
                    }

                    console.log(error)

                })
                .finally(() => {
                    this.loading = false
                })
        },
        getAllDesks() {
            axios.get('/api/v1/desks')
                .then(response => {
                    this.desks = response.data.data;
                })
                .catch(error => {
                    this.errored = true
                    console.log(error)
                })
                .finally(() => {
                    this.loading = false
                })
        },

        deleteDesk(id) {
            if (confirm('Вы уверены? Удалится всё содержимое доски!')) {
                axios.delete('/api/v1/desks/' + id)
                    .then(response => {
                        this.desks = []
                        this.getAllDesks();
                    })
                    .catch(error => {
                        this.errored = true
                        console.log(error)
                    })
                    .finally(() => {
                        this.loading = false
                    })
            }
        }
    },
    mounted() {
        this.getAllDesks()
    },
    validations: {
        name: {
            required,
            maxLength: maxLength(255)
        }
    }
}
</script>
