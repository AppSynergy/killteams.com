export default {
    computed: {
        killteam() {
            return this.$store.getters.getKillteam
        },
        killteamName: {
            get() {
                return this.$store.getters.getName
            },
            set(value) {
                this.$store.commit('setName', value)
            }
        }
    }
}
