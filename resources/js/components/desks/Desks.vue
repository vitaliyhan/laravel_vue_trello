<template>
    <div class="container">
        <h1>Доски</h1>
        <div class="row">
            <div class="col-lg-4" v-for="desk of desks">
                <div class="card mt-3">
                    <a href="#" class="card-body">
                        <h5 class="card-title">{{ desk.name }}</h5>

                    </a>
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
    mounted() {
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
    }
}
</script>
