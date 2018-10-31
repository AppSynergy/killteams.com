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
export default {
    mixins: [
        itemsToText
    ],
    props: [
        'fighterId', 'factionId', 'miniatureArmament',
    ],
    computed: {
        factions() {
            return this.$store.getters.getFactions
        },
        faction() {
            return _.find(this.factions, { id: this.factionId })
        },
        armament() {
            return this.$store.getters.getFighterArmament({
                fighterId: this.fighterId,
                miniatureArmament: this.miniatureArmament,
            })
        }
    }
}
</script>
