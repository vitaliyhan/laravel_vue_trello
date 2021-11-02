<template>
    <div class="container">
        <div class="form-group">
            <input type="text" @blur="saveName" v-model="name" class="form-control">
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
    }
}
</script>
