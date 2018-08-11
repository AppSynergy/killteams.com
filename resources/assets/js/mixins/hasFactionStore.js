export default {
    computed: {
        factions() {
            return this.$store.getters.getFactions
        },
        faction() {
            return this.$store.getters.getFaction
        }
    },
    methods: {
        setFactions(data) {
            this.$store.commit('setFactions', data)
        },
        setFaction(data) {
            this.$store.commit('setFaction', data)
        }
    }
}
