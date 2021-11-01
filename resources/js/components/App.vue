<template>
    <div class="container">
       <router-link :to="{ name: 'home' }">Home</router-link>
       <router-link :to="{ name: 'about' }">about</router-link>
        <div>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
export default {
    name: "App"
}
</script>
