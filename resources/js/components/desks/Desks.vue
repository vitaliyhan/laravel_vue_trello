<template>
    <div class="container">
        <h1>Доски</h1>
        <div class="row">
            <div class="col-lg-4" v-for="desk of desks">
                <div class="card mt-3 text-center">
                    <router-link :to="{name: 'showDesk', params: {deskId:desk.id}}" class="card-body">
                        <h4 class="card-title">{{ desk.name }}</h4>
                    </router-link>
                    <div class="card-body">
                        <a href="#" @click="deleteDesk(desk.id)" class="btn btn-outline-danger"><i
                            class="bi bi-trash-fill"></i> Удалить</a>
                    </div>
                </div>
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
export default {
    name: "Desks",
    data() {
        return {
            desks: [],
            errored: false,
            loading: true
        }
    },
    methods: {
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
                        this.desks=[]
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
    }
}
</script>
