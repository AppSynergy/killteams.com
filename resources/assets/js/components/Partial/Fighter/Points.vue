<template>
    <span class="vue-partial-fighter-points" dusk="points">
        {{ points }}
    </span>
</template>

<script>
export default {
    props: [
        'factionId', 'miniature', 'wargearSelectors'
    ],
    computed: {
        factions() {
            return this.$store.getters.getFactions
        },
        faction() {
            return _.find(this.factions, { id: this.factionId })
        },
        points() {
            const baseCost = this.miniature.points
            let wargearCost = 0
            _.each(this.wargearSelectors, (selector) => {
                if (selector.isSelected) {
                    _.each(this.ensureArray(selector.option), (item_id) => {
                        if (item_id) {
                            let item = _.find(this.faction.wargear, {id: item_id})
                            wargearCost += item.points
                        }
                    })
                }
            })
            return baseCost + wargearCost
        }
    },
    methods: {
        ensureArray(value) {
            return (_.isArray(value)) ? value : [value]
        }
    }
}
</script>
