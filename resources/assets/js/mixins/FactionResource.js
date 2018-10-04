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
            console.log("Fetch factions")
            axios.get(API_URL + '/factions').then(response => {
                const factions = response.data.data
                this.factions = factions
                if (this.factionsLoaded) {
                    // from Sidebar.vue @TODO
                    //this.fetchFaction(this.selectedFactionId)
                }
                console.log("Fetched factions")
            })
        },
        fetchFaction(faction_id) {
            const faction = _.find(this.factions, { id: faction_id })

            if (!faction.full) {
                axios.get(API_URL + '/factions/' + faction_id).then(response => {
                    const faction = response.data.data
                    this.setFaction(faction)
                    console.log("fetched Faction", faction_id, faction)
                })
            }
        },
        setFaction(faction) {
            this.$store.commit('setFaction', faction)
        }
    }
}
