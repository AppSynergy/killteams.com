<template>
    <div class="vue-partial-fighter-armament">

        <span class="my-2 d-block">
            <strong>Armed with:</strong> <em
                v-html="itemListToText(armament, faction.wargear, ' and ')"></em><br>
        </span>

    </div>
</template>

<script>
import itemsToText from '../../../mixins/itemsToText.js'
import FactionResource from '../../../mixins/FactionResource.js'
export default {
    props: [
        'factionId', 'armament',
    ],
    computed: {
        faction() {
            return _.find(this.factions, { id: this.factionId })
        }
    },
    mixins: [
        itemsToText, FactionResource,
    ]
}
</script>
