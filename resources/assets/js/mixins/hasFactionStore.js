export default {
    computed: {
        factions() {
            return this.$store.getters.getFactions
        },
        faction() {
            return this.$store.getters.getFaction
        }
    },
}
