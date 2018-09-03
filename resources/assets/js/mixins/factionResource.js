export default {
    data() {
        return {
            availableFactions: [],
        }
    },
    computed: {
        factions() {
            return this.$store.getters.getFactions
        }
    },
    mounted() {
        console.log("mounted")
        this.fetchFactions()
    },
    methods: {
        fetchFaction(id) {
            axios.get(API_URL + '/factions/' + id).then(response => {
                const faction = response.data.data
                this.currentFactionId = faction.id
                this.$store.commit('setFaction', faction)
            })
        },
        fetchFactions() {
            axios.get(API_URL + '/factions').then(response => {
                this.availableFactions = response.data.data
            })
        }
    }
}
