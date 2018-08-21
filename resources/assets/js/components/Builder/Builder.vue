<template>
    <div class="vue-builder-builder">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-5 col-lg-4">
                    <div class="card mb-4">

                        <span class="card-header">Choose Your Fighters</span>

                        <div class="card-body"
                            v-if="'sandbox' == gameMode">
                            <select class="custom-select custom-select-sm"
                                v-model="sandboxSelectedFactionId"
                                v-on:change="sandboxChangeFaction">
                                <option v-for="faction in availableFactions"
                                    :value="faction.id">{{ faction.name }}
                                </option>
                            </select>
                        </div>

                        <div class="card-body"
                            v-if="faction != undefined">
                            <div class="d-flex align-items-center my-3 flex-wrap"

                                v-for="datasheet in faction.datasheets">

                                <div class="h5 mr-3 font-weight-bold">
                                    {{ datasheet.name }}
                                </div>

                                <button class="btn btn-primary btn-sm mr-3 mb-2"
                                    v-on:click="addFighter(mini)"
                                    v-for="mini in datasheet.miniatures">
                                    {{ mini.name }}
                                </button>

                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <router-link :to="'/' + gameMode + '/choosefaction'">
                            Back
                        </router-link>
                    </div>
                </div>
                <div class="col-12 col-sm-7 col-lg-8">
                    <div class="card mb-4">

                        <span class="card-header">Command Roster</span>

                        <div class="card-body">
                            <div class="fighter-list">
                                <span v-for="fighter in fighters">
                                    <fighter
                                        :faction="faction"
                                        :fighter-init="fighter"
                                    ></fighter>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Fighter from './Fighter.vue'
export default {
    components: {
        Fighter
    },
    props: [
        'factionId', 'factionKeyword', 'gameMode'
    ],
    data() {
        return {
            availableFactions: [],
            currentFactionId: false,
            factions: {},
            sandboxSelectedFactionId: this.factionId
        }
    },
    computed: {
        faction() {
            return this.factions[this.currentFactionId]
        },
        fighters() {
            return this.$store.getters.getFighters
        }
    },
    mounted() {
        this.fetchFaction(this.factionId)
        if ('sandbox' == this.gameMode) {
            this.fetchFactions();
        }
    },
    methods: {
        fetchFaction(id) {
            axios.get(API_URL + '/factions/' + id).then(response => {
                const faction = response.data.data
                this.factions[faction.id] = faction
                this.currentFactionId = faction.id
            })
        },
        fetchFactions() {
            axios.get(API_URL + '/factions').then(response => {
                this.availableFactions = response.data.data
            })
        },
        addFighter(mini) {
            this.$store.commit('addFighter', mini)
        },
        sandboxChangeFaction() {
            const id = this.sandboxSelectedFactionId
            if (id) {
                this.fetchFaction(id)
            }
        }
    }
}
</script>
