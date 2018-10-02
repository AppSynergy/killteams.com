export default {
    computed: {
        specialisms: {
            get() {
                return this.$store.getters.getSpecialisms
            },
            set(value) {
                this.$store.commit('setSpecialisms', value)
            }
        },
        specialismsLoaded: {
            get() {
                return this.$store.getters.getSpecialismsLoaded
            },
            set(value) {
                this.$store.commit('setSpecialismsLoaded', value)
            }
        }
    },
    mounted() {
        if (!this.specialismsLoaded) {
            this.fetchSpecialisms()
            this.specialismsLoaded = true
        }
    },
    methods: {
        fetchSpecialisms() {
            axios.get(API_URL + '/specialisms').then(response => {
                this.specialisms = response.data.data
            })
        }
    }
}
