<template>
    <div class="vue-builder-mini-explorer">

        <select class="form-control" v-model="selectedFaction">
            <option disabled="disabled" :value="null">Choose faction</option>
            <option v-for="faction in factions" :value="faction.id">
                {{ faction.name }}
            </option>
        </select>

        <div class="my-5" v-if="faction">
            <span v-for="datasheet in faction.datasheets">
                <h3 class="h5 d-inline">
                    {{ datasheet.name }}:
                </h3>
                <button class="p-2 m-2 btn btn-primary"
                    v-on:click="addFighter(mini)"
                    v-for="mini in datasheet.miniatures">
                    {{ mini.name }}
                </button>
            </span>
        </div>

    </div>
</template>

<script>
import hasFactionStore from '../../mixins/hasFactionStore.js'
export default {
    mixins: [ hasFactionStore ],
    data() {
        return {
            selectedFaction: 1 //null
        }
    },
    mounted() {
        this.fetchFactions()
        // dev - auto load ad mech
        this.fetchFaction(1)
    },
    watch: {
        selectedFaction(newFactionId, oldFactionId) {
            this.fetchFaction(newFactionId)
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
        addFighter(data) {
            this.$store.commit('addFighter', data)
        }
    }
}
</script>
