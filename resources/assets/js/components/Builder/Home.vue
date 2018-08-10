<template>
    <div class="vue-builder-home">
        <div class="container my-5">

            <select class="form-control" v-model="selectedFaction">
                <option disabled="disabled" :value="null">Choose faction</option>
                <option v-for="faction in factions" :value="faction.id">
                    {{ faction.name }}
                </option>
            </select>

            <div class="my-5" v-if="faction">
                <div class="card my-2 p-4" v-for="datasheet in faction.datasheets">
                    {{ datasheet.name }}
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
        }
    }
}
</script>
