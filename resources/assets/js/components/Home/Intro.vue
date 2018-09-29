<template>
    <div class="vue-home-intro">
        <div class="container">
            <div class="card">

                <span class="card-header h3">Kill Team Builder</span>

                <div class="card-body">
                    <div class="row">
                        <div class="col col-12 col-sm-6">
                            <router-link class="btn btn-primary"
                                dusk="new-kill-team"
                                :to="{ name: 'gamemode' }">
                                Start a new Kill Team
                            </router-link>
                        </div>
                        <div class="col col-12 col-sm-6">
                            <div class="px-3 py-2" v-for="killteam in killteams">
                                <span class="h4">{{ killteam.name }}</span>
                                <a class="btn btn-primary"
                                    dusk="load-kill-team"
                                    v-on:click="loadKillteam(killteam, 'sandbox')">
                                    Load
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
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
                    factionId: killteam.faction_id,
                    factionKeyword: killteam.faction_keyword
                }
            })
            this.$store.commit('loadKillteam', killteam)
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
