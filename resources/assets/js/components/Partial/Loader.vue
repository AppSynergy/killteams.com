<template>
    <div class="vue-partial-loader">
        <div class="px-3 py-2" v-for="killteam in killteams">
            <span class="h4">{{ killteam.name }}</span>
            <a class="btn btn-primary btn-sm mr-2 mb-2"
                dusk="load-kill-team"
                v-on:click="loadKillteam(killteam, 'sandbox')">
                Load
            </a>
        </div>
    </div>
</template>

<script>
import KillteamsResource from '../../mixins/KillteamsResource.js'
export default {
    mixins: [
        KillteamsResource,
    ],
    methods: {
        loadKillteam(killteam, gameMode) {
            this.$router.push({
                name: 'builder',
                params: {
                    gameMode: gameMode,
                    factionId: '1',
                    factionKeyword: 'ADEPTUS ASTARTES'
                }
            })
            this.$store.dispatch('loadKillteam', killteam)
        }
    }
}
</script>
