<template>
    <div class="vue-builder-builder">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-5 col-lg-4">
                    <div class="card">

                        <span class="card-header">Choose Fighters</span>

                        <div class="card-body">
                            <div class="d-flex align-items-center my-3 flex-wrap"
                                v-if="faction != null"
                                v-for="datasheet in faction.datasheets">

                                <span class="mr-3 font-weight-bold">
                                    {{ datasheet.name }}
                                </span>

                                <button class="btn btn-primary mr-3 mb-2"
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
                    <div class="card">

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
            faction: {
                datasheets: []
            }
        }
    },
    computed: {
        fighters() {
            return this.$store.getters.getFighters
        }
    },
    mounted() {
        this.fetchFaction(this.factionId)
    },
    methods: {
        fetchFaction(id) {
            axios.get(API_URL + '/factions/' + id).then(response => {
                this.faction = response.data.data
            })
        },
        addFighter(mini) {
            this.$store.commit('addFighter', mini)
        }
    }
}
</script>
