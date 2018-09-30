export default {
    computed: {
        specialisms: {
            get() {
                return this.$store.getters.getSpecialisms
            },
            set(value) {
                this.$store.commit('setSpecialisms', value)
            }
        }
    },
    mounted() {
        console.log("mounted a sr")
        this.fetchSpecialisms()
    },
    methods: {
        fetchSpecialisms() {
            axios.get(API_URL + '/specialisms').then(response => {
                this.specialisms = response.data.data
            })
        }
    }
}
