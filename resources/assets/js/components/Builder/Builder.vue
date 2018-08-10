<template>
    <div class="vue-builder-builder">
        <router-view></router-view>
    </div>
</template>

<script>
import Home from './Home.vue'
export default {
    created() {
        this.$router.addRoutes([
            { path: '/home', component: Home, props: true, name: 'home' },
        ])
        this.$router.push('home')
    }
}
</script>
