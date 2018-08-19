<template>
    <div class="vue-app">
        <router-view></router-view>
    </div>
</template>

<script>
import Builder from './Builder/Tester.vue'
export default {
    created() {
        this.$router.addRoutes([
            { path: '/test', component: Builder, props: true, name: 'test' },
        ])
        this.$router.push('test')
    }
}
</script>
