<template>
    <div class="vue-app">
        <router-view></router-view>
    </div>
</template>

<style lang="sass">
    @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600,700')

    .vue-app
        font-family: 'Source Sans Pro', sans-serif
</style>


<script>

import Intro from './Home/Intro.vue'
import GameMode from './Home/GameMode.vue'
import ChooseFaction from './Home/ChooseFaction.vue'
import Builder from './Builder/Builder.vue'
//import Tester from './Builder/Tester.vue'
export default {
    created() {
        this.$router.addRoutes([
            { path: '/', component: Intro, props: true, name: 'intro' },
            { path: '/home/gamemode', component: GameMode, props: true, name: 'gamemode' },
            { path: '/:gameMode/choosefaction', component: ChooseFaction, props: true, name: 'choosefaction' },
            { path: '/:gameMode/:factionId/:factionKeyword/builder', component: Builder, props: true, name: 'builder' },
            //{ path: '/test', component: Tester, props: true, name: 'test' },
        ])
        //this.$router.push({ name: 'intro' })
    }
}
</script>
