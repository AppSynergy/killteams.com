export default {
    methods: {
        // Wargear Lists
        getWargearText(fighter) {
            return _.map(fighter.armament, (x) => (this.getWargearName(x))).join(', ')
        },
        getWargearName(wargear_id) {
            if (_.isArray(wargear_id)) {
                return _.map(wargear_id, (x) => (this.getWargearName(x))).join(', ')
            }
            return _.find(this.faction.wargear, (x) => (x.id == wargear_id)).name
        }
    }
}
