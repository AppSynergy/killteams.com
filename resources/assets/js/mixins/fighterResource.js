export default {
    computed: {
        fighters: {
            get() {
                return this.$store.getters.getFighters
            },
            set(value) {
                this.$store.commit('setFighters', value)
            }
        },
    }
}
