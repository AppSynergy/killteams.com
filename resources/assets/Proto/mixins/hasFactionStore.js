export default {
    computed: {
        // Getters
        factions() {
            return this.$store.getters.getFactions
        },
        faction() {
            return this.$store.getters.getFaction
        }
    },
    methods: {
        // Setters
        setFactions(data) {
            this.$store.commit('setFactions', data)
        },
        setFaction(data) {
            this.$store.commit('setFaction', data)
        },
        // Ajax Fetchers
        fetchFactions() {
            axios.get(API_URL + '/factions')
                .then(response => (this.setFactions(response.data.data)))
        }
    }
}
