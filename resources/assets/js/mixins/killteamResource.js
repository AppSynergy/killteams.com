export default {
    computed: {
        killteam: {
            get() {
                return this.$store.getters.getKillteam
            },
            set(value) {
                this.$store.commit('setKillteam', value)
            }
        },
    }
}
