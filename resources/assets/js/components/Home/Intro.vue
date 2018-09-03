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
                                <router-link class="btn btn-primary"
                                    dusk="load-kill-team"
                                    :to="{
                                        name: 'builder',
                                        params: {
                                            gameMode: 'sandbox',
                                            factionId: killteam.faction_id,
                                            factionKeyword: 'foo',
                                        }
                                    }">
                                    Load
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import FactionResource from '../../mixins/factionResource.js'
export default {
    mixins: [
        FactionResource
    ],
    data() {
        return {
            killteams: [],
        }
    },
    computed: {
        factions() {
            return this.$store.getters.getFactions
        },
    },
    mounted() {
        this.getKillteams()
    },
    methods: {
        getKillteams() {
            this.killteams = axios.get(API_URL + '/killteams').then(response => {
                const killteams = response.data.data
                this.killteams = killteams
            })
        }
    }
}
</script>
