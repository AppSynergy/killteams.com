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
        if (!this.factionsLoaded) {
            this.fetchFactions()
            this.factionsLoaded = true
        }
    },
    methods: {
        fetchFactions() {
            axios.get(API_URL + '/factions').then(response => {
                const factions = response.data.data
                this.factions = _.filter(factions, (x) => x.id == 1 || x.id == 7)
            })
        }
    }
}
