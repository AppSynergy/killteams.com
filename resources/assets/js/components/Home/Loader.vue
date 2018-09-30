<template>
    <div class="vue-home-loader">
        <div class="px-3 py-2" v-for="killteam in killteams">
            <span class="h4">{{ killteam.name }}</span>
            <a class="btn btn-primary"
                dusk="load-kill-team"
                v-on:click="loadKillteam(killteam, 'sandbox')">
                Load
            </a>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            killteams: [],
        }
    },
    mounted() {
        this.getKillteams()
    },
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
        },
        getKillteams() {
            this.killteams = axios.get(API_URL + '/killteams').then(response => {
                const killteams = response.data.data
                this.killteams = killteams
            })
        }
    }
}
</script>
