export default {
    computed: {
        factions: {
            get() {
                return this.$store.getters.getFactions
            },
            set(value) {
                this.$store.commit('setFactions', value)
            }
        },
        factionsLoaded: {
            get() {
                return this.$store.getters.getFactionsLoaded
            },
            set(value) {
                this.$store.commit('setFactionsLoaded', value)
            }
        }
    },
    mounted() {
        this.init()
    },
    methods: {
        init() {
            const faction_id = parseInt(this.factionId, 10)
            if (!this.factionsLoaded && this.bootFactionId && faction_id > 0) {
                this.factionsLoaded = true
                this.$store.dispatch('fetchFactions').then(() => {
                    this.$store.dispatch('fetchFaction', { faction_id })
                })
            }
        }
    }
}
