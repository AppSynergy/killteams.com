<template>
    <div class="vue-builder-home">
        <div class="container my-2">

            <select class="form-control" v-model="selectedFaction">
                <option disabled="disabled" :value="null">Choose faction</option>
                <option v-for="faction in factions" :value="faction.id">
                    {{ faction.name }}
                </option>
            </select>

            <div class="my-5" v-if="faction">
                <div class="card my-4"
                    v-for="datasheet in faction.datasheets">
                    <div class="card-header">
                        {{ datasheet.name }}
                    </div>
                    <div class="card-body">
                        <h2 class="p-2 m-2 badge badge-primary"
                            v-on:click="addFighter(mini)"
                            v-for="mini in datasheet.miniatures">
                            {{ mini.name }}
                        </h2>
                    </div>
                </div>
            </div>

        </div>

        <command-roster>

        </command-roster>

    </div>
</template>

<script>
import CommandRoster from './CommandRoster.vue'
export default {
    props: [],
    components: { CommandRoster },
    data() {
        return {
            selectedFaction: 5 //null,
        }
    },
    mounted() {
        this.fetchFactions()
        // dev - auto load ad mech
        this.fetchFaction(5)
    },
    watch: {
        selectedFaction(newFactionId, oldFactionId) {
            this.fetchFaction(newFactionId)
        }
    },
    computed: {
        factions() {
            return this.$store.getters.getFactions
        },
        faction() {
            return this.$store.getters.getFaction
        }
    },
    methods: {
        fetchFactions() {
            axios.get(API_URL + '/factions')
                .then(response => (this.setFactions(response.data.data)))
        },
        fetchFaction(id) {
            axios.get(API_URL + '/factions/' + id)
                .then(response => (this.setFaction(response.data.data)))
        },
        setFactions(data) {
            this.$store.commit('setFactions', data)
        },
        setFaction(data) {
            this.$store.commit('setFaction', data)
        },
        addFighter(data) {
            this.$store.commit('addFighter', data)
        }
    }
}
</script>
