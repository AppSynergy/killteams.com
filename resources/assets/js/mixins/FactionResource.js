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
            if (!this.factionsLoaded) {
                this.fetchFactions()
                this.factionsLoaded = true
            }
        },
        fetchFactions() {
            axios.get(API_URL + '/factions').then(response => {
                const factions = response.data.data
                this.factions = factions
                if (this.factionsLoaded) {
                    // from Sidebar.vue @TODO
                    //this.fetchFaction(this.selectedFactionId)
                }
            })
        },
        setFaction(faction) {
            this.$store.commit('setFaction', faction)
        }
    }
}
