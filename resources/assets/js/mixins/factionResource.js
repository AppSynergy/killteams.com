export default {
    computed: {
        factions: {
            get() {
                return this.$store.getters.getFactions
            },
            set(value) {
                this.$store.commit('setFactions', value)
            }
        }
    },
    mounted() {
        this.fetchFactions()
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
