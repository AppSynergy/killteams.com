<template>
    <div class="vue-builder-home">
        <div class="container">
            <div class="card p-4 my-4" v-for="faction, i in factionData">
                <h3 class="h3 mb-3">
                    {{ faction.name }}
                </h3>
                <div class="" v-for="datasheet in faction.datasheets">
                    <h4 class="h4 mb-2">
                        {{ datasheet.name }}
                    </h4>
                    <div class="card mb-2" v-for="mini in datasheet.miniatures">
                        <div class="card-header">
                            {{ mini.name }}
                        </div>
                        <div class="card-body">
                            {{ mini.armament }}
                            {{ mini.wargear_options }}
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
        factions() {
            return this.$store.getters.getFactions
        },
    },
    methods: {

    }
}
</script>
