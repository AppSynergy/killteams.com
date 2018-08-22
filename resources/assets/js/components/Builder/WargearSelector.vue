<template>
    <div class="vue-builder-wargear-selector">

        <div class="form-check form-inline pl-0" v-if="selection">

            <input type="checkbox" class="form-check-input"
                v-model="selection.isSelected"
                v-on:change="selectWargearCheckbox"
                :disabled="availableOrSelected == false">

            <span class="text-nowrap">
                <template v-if="'REPLACE' == wgo.may">
                    Replace {{ itemListToText(wgo.replace, wargear, ' and ') }}
                    with&nbsp;
                </template>

                <template v-if="'TAKE' == wgo.may">
                    Take&nbsp;
                </template>
            </span>

            <span v-if="'ALLOF' == wgo.method">
                {{ itemOrItemListToText(wgo.options, wargear, ' and ') }}
            </span>

            <span v-if="'ONEOF' == wgo.method">
                <select class="ml-2 custom-select custom-select-sm"
                    v-model="selection.option"
                    v-on:change="selectWargearDropdown"
                    :disabled="availableOrSelected == false">
                    <option v-for="choice in wgo.options" :value="choice">
                        {{ itemOrItemListToText(choice, wargear, ' and ') }}
                    </option>
                </select>
            </span>

        </div>
    </div>
</template>

<script>
import itemsToText from '../../mixins/itemsToText.js'
export default {
    mixins: [
        itemsToText
    ],
    props: [
        'armament', 'available', 'fighterId', 'selectionId', 'wargear', 'wgo'
    ],
    data() {
        return {

        }
    },
    computed: {
        selection() {
            return this.$store.getters.getWargearSelectors(this.fighterId, this.selectionId)
        },
        availableOrSelected() {
            return this.available || this.selection.isSelected
        }
    },
    methods: {
        selectWargearCheckbox() {
            if (this.selection.option) {
                this.selectWargear()
            }
        },
        selectWargearDropdown() {
            if (!this.selection.isSelected) {
                this.selection.isSelected = true
            }
            this.selectWargear()
        },
        selectWargear() {
            this.$store.commit('selectWargear', {
                selection: this.selection,
                fighter_id: this.fighterId,
                faction_id: this.factionId,
            })
        }
    }
}
</script>
