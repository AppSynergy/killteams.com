<template>
    <div class="vue-builder-builder">
        <router-view></router-view>
    </div>
</template>

<script>
import Home from './Builder/Home.vue'
export default {
    created() {
        this.$router.addRoutes([
            { path: '/home', component: Home, props: true, name: 'home' },
        ])
        this.$router.push('home')
    }
}
</script>
