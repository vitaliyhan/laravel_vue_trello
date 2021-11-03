<template>
    <div class="container">
        <h1>{{ name }}</h1>
        <div class="form-group">
            <input v-model="name" :class="{ 'is-invalid': $v.name.$error }" class="form-control" type="text"
                   @blur="saveName">
            <div v-if="!$v.name.required" class="invalid-feedback">
                Обязательное поле
            </div>
            <div v-if="!$v.name.maxLength" class="invalid-feedback">
                Максимальное количество символов {{ $v.name.$params.maxLength.max }}
            </div>
        </div>


        <div v-if="errored" class="alert alert-danger" role="alert">
            Ошибка загрузки данных!
        </div>
        <div v-if="loading" class="text-center m-3">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Загрузка...</span>
            </div>
        </div>

        <form class="add_new" @submit.prevent="addNewDeskList">
            <div class="mb-3">
                <label class="form-label"  for="name">Название списка</label>
                <input id="name" v-model="desk_list_name"
                       aria-describedby="nameHelp"
                       class="form-control"
                       :class="{ 'is-invalid': $v.desk_list_name.$error }"
                       type="text">
                <div v-if="!$v.desk_list_name.required" class="invalid-feedback">
                    Обязательное поле
                </div>
                <div v-if="!$v.desk_list_name.maxLength" class="invalid-feedback">
                    Максимальное количество символов {{ $v.desk_list_name.$params.maxLength.max }}
                </div>
            </div>

            <button class="btn btn-primary" type="submit">Добавить список</button>
        </form>

        <div class="row">
            <div v-for="desk_list of desk_lists" class="col-lg-4">
                <div class="card mt-3 text-center">
                    <router-link :to="{name: 'showDesk', params: {deskId:desk_list.id}}" class="card-body">
                        <h4 class="card-title">{{ desk_list.name }}</h4>
                    </router-link>
                    <div class="card-body">
                        <a class="btn btn-outline-danger" href="#" @click="deleteDeskList(desk_list.id)"><i
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
    props: [
        'deskId'
    ],
    data() {
        return {
            name: null,
            loading: true,
            errored: false,
            desk_lists: [],
            desk_list_name: null
        }
    },
    methods: {
        saveName() {
            this.$v.name.$touch()
            if (this.$v.name.$anyError) {
                return;
            }
            this.$v.$reset();
            axios.put('/api/v1/desks/' + this.deskId, {
                name: this.name,
            })
                .then(response => {
                    this.$v.$reset();
                })
                .catch(error => {
                    this.errored = true
                    console.log(error)
                })
                .finally(() => {
                    this.loading = false
                })
        },

        addNewDeskList() {
            this.$v.name.$touch()
            if (this.$v.name.$anyError) {
                return;
            }
            this.$v.$reset();
            this.errored = false

            axios.post('/api/v1/desk-lists', {
                name: this.desk_list_name,
                desk_id: this.deskId,
            })
                .then(response => {
                    this.$v.$reset();
                    this.desk_list_name = null
                    this.getDeskLists();
                })
                .catch(error => {
                    this.errored = true
                    console.log(error.response)

                })
                .finally(() => {
                    this.loading = false
                })
        },

        deleteDeskList(id) {
            if (confirm('Вы уверены? Удалится всё содержимое списка!')) {
                axios.delete('/api/v1/desk-lists/' + id)
                    .then(response => {
                        this.desk_lists = []
                        this.getDeskLists();
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
        getDeskLists() {
            axios.get('/api/v1/desk-lists', {
                params: {
                    desk_id: this.deskId
                }
            })
                .then(response => {
                    console.log(response)
                    this.desk_lists = response.data.data;
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
        this.getDeskLists()
    },
    validations: {
        name: {
            required,
            maxLength: maxLength(255)
        },
        desk_list_name: {
            required,
            maxLength: maxLength(255)
        }
    }

}
</script>
