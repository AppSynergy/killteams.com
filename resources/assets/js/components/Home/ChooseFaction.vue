<template>
    <div class="vue-home-choose-faction">
        <div class="container">
            <div class="card">

                <span class="card-header h2">Kill Team Builder &middot; Choose a Faction</span>

                <div class="card-body">
                    <span v-for="faction in factions">
                        <router-link class="btn btn-info mr-3 mb-3"
                            :to="'/sandbox/' + faction.id + '/'
                            + faction.faction_keyword + '/builder'">
                            {{ faction.name }}
                        </router-link>
                    </span>
                </div>

                <div class="card-footer">
                    <router-link :to="{ name: 'gamemode' }">
                        Back
                    </router-link>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'gameMode'
    ],
    data() {
        return {
            factions: []
        }
    },
    mounted() {
        this.fetchFactions()
    },
    methods: {
        fetchFactions() {
            axios.get(API_URL + '/factions').then(response => {
                this.factions = response.data.data
            })
        },
    }
}
</script>
