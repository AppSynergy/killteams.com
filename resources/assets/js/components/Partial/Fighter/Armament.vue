<template>
    <div class="vue-partial-fighter-armament">

        <span class="my-2 d-block">
            <strong>Armed with:</strong> <em
                v-html="itemListToText(currentArmament, faction.wargear, ' and ')"></em><br>
        </span>

    </div>
</template>

<script>
import itemsToText from '../../../mixins/itemsToText.js'
import FactionResource from '../../../mixins/FactionResource.js'
export default {
    mixins: [
        itemsToText, FactionResource,
    ],
    props: [
        'armament', 'factionId', 'wargearSelectors'
    ],
    computed: {
        faction() {
            return _.find(this.factions, { id: this.factionId })
        },
        currentArmament() {
            let armament = _.clone(this.armament)
            _.each(this.wargearSelectors, (selector) => {
                if (selector.isSelected) {
                    _.each(this.ensureArray(selector.replace), (item) => {
                        _.remove(armament, x => x == item)
                    })
                    _.each(this.ensureArray(selector.option), (item) => {
                        armament.push(item)
                    })
                }
            })
            return armament
        }
    },
    methods: {
        ensureArray(value) {
            return (_.isArray(value)) ? value : [value]
        }
    }

}
</script>
