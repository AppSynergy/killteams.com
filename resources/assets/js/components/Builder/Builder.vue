<template>
    <div class="vue-builder-builder">
        <div class="container">
            ...
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'factionId', 'factionKeyword', 'gameMode'
    ],
    data() {
        return {
            faction: null
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
    }
}
</script>
