<template>
    <div class="vue-partial-fighter-wargear-selector">

        <div class="form-check form-inline pl-0" v-if="selector">

            <input type="checkbox" class="form-check-input"
                v-model="selector.isSelected"
                v-on:change="updateWargearCheckbox"
                :disabled="isDisabled">

            <span class="text-nowrap">
                <template v-if="'REPLACE' == selector.wgo.may">
                    Replace {{ itemListToText(selector.wgo.replace, faction.wargear, ' and ') }}
                    with&nbsp;
                </template>

                <template v-if="'TAKE' == selector.wgo.may">
                    Take&nbsp;
                </template>
            </span>

            <span v-if="'ALLOF' == selector.wgo.method">
                {{ itemOrItemListToText(selector.wgo.options, faction.wargear, ' and ') }}
            </span>

            <span v-if="'ONEOF' == selector.wgo.method">
                <select class="ml-2 custom-select custom-select-sm select-wargear-option"
                    dusk="select-wargear-option"
                    v-model="selector.option"
                    v-on:change="updateWargearDropdown"
                    :disabled="isDisabled">
                    <option v-for="choice in selector.wgo.options" :value="choice">
                        {{ itemOrItemListToText(choice, faction.wargear, ' and ') }}
                    </option>
                </select>
            </span>

        </div>
    </div>
</template>

<script>
import itemsToText from '../../../mixins/itemsToText.js'
export default {
    mixins: [
        itemsToText,
    ],
    props: [
        'available', 'fighter', 'gameMode', 'selector',
    ],
    computed: {
        isDisabled() {
            return (this.availableOrSelected == false)
        },
        availableOrSelected() {
            return this.available || this.selector.isSelected
        },
        factions() {
            return this.$store.getters.getFactions
        },
        faction() {
            return _.find(this.factions, { id: this.fighter.faction_id })
        }
    },
    methods: {
        updateWargearCheckbox() {
            if (this.selector.option) {
                this.updateWargear()
            }
        },
        updateWargearDropdown() {
            if (!this.selector.isSelected) {
                this.selector.isSelected = true
            }
            this.updateWargear()
        },
        updateWargear() {
            this.$store.commit('updateWargearSelector', {
                fighterId: this.fighter.id,
                selectorId: this.selector.id,
                selector: this.selector,
            })
        }
    }
}
</script>
