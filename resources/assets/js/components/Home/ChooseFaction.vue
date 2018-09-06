<template>
    <div class="vue-home-choose-faction">
        <div class="container">
            <div class="card">

                <span class="card-header h2">Kill Team Builder &middot; Choose a Faction</span>

                <div class="card-body">
                    <div class="row">
                        <div class="col col-12 col-lg-6 col-xl-4 mb-3" 
                            v-for="faction in factions">
                            <div class="bg-dark text-light p-3 rounded h-100">
                                <router-link class="btn btn-primary mr-3 mb-3"
                                    :dusk="faction.name"
                                    :class="(isDisabled(faction) ? 'disabled' : '')"
                                    :event="(isDisabled(faction) ? '' : 'click')"
                                    :disabled="isDisabled(faction)"
                                    :to="'/' + gameMode + '/' + faction.id + '/'
                                    + faction.faction_keyword + '/builder'">
                                    {{ faction.name }}
                                </router-link>
                                <p>
                                    <span v-if="isDisabled(faction)">
                                        Coming soon.
                                    </span>
                                    <span v-else>
                                        {{ faction.description }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <router-link :to="{ name: 'gamemode' }" dusk="back">
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
        isDisabled(faction) {
            return faction.has_datasheets == false
        },
        fetchFactions() {
            axios.get(API_URL + '/factions').then(response => {
                this.factions = response.data.data
            })
        },
    }
}
</script>
