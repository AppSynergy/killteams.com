<template>
    <div class="vue-builder-home">
        <div class="container">
            <div class="card p-4 my-4" v-for="faction, i in factionDataSorted" :key="i">
                <span class="h1 mb-3 font-weight-bold text-uppercase">
                    {{ faction.name }}
                </span>
                <div class="card mb-5 p-3 bg-dark text-light" v-for="datasheet, d_i in faction.datasheets">
                    <span class="h2 mb-2 font-weight-bold">
                        {{ datasheet.name }}
                    </span>
                    <small>{{ datasheet.keywords.join(' &middot; ') }}</small>
                    <small>{{ datasheet.abilities.join(' &middot; ') }}</small>
                    <div class="card body text-dark my-3 p-3" v-for="mini, m_i in datasheet.miniatures">
                        <fighter
                            :faction="faction"
                            :fighter-init="mini"
                        ></fighter>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="sass">
    .table td, .badge
        font-family: Courier
    .alert
        font-size: 110%
</style>

<script>
import Fighter from './Fighter.vue'
export default {
    components: {
        Fighter
    },
    data() {
        return {
            factionData: []
        }
    },
    mounted() {
        axios.get(API_URL + '/factions').then(response => {
            this.$store.commit('setFactions', response.data.data)
            _.each(this.factions, (f) => {
                axios.get(API_URL + '/factions/' + f.id).then(response => {
                    this.factionData.push(response.data.data)
                })

            })
        })
    },
    computed: {
        factionDataSorted() {
            return _.sortBy(this.factionData, 'id')
        },
        factions() {
            return this.$store.getters.getFactions
        },
    },
    methods: {

    }
}
</script>
