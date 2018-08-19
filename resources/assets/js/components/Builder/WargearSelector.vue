<template>
    <div class="vue-builder-wargear-selector">

        <span class="form-check form-inline pl-0">

            <input type="checkbox" class="form-check-input"
                v-model="selection.isSelected"
                v-on:change="changeWargear">

            <span v-if="'REPLACE' == wgo.may">
                Replace {{ itemListToText(wgo.replace, wargear, ' and ') }}
                with&nbsp;
            </span>

            <span v-if="'TAKE' == wgo.may">
                Take&nbsp;
            </span>

            <span v-if="'ALLOF' == wgo.method">
                {{ itemOrItemListToText(wgo.options, wargear, ' and ') }}
            </span>

            <span v-if="'ONEOF' == wgo.method">
                <select class="form-control ml-2"
                    v-model="selection.option"
                    v-on:change="changeWargear">
                    <option v-for="choice in wgo.options" :value="choice">
                        {{ itemOrItemListToText(choice, wargear, ' and ') }}
                    </option>
                </select>
            </span>

        </span>
    </div>
</template>

<script>
import itemsToText from '../../mixins/itemsToText.js'
export default {
    mixins: [
        itemsToText
    ],
    props: [
        'armament', 'factionId', 'fighterId', 'wargear', 'wgo'
    ],
    data() {
        return {
            selection: {
                faction_id: this.factionId,
                fighter_id: this.fighterId,
                isSelected: false,
                replace: this.wgo.replace,
                option: ('ALLOF' == this.wgo.method) ? this.wgo.options : null
            }
        }
    },
    methods: {
        changeWargear() {
            this.$emit('selectWargear', this.selection)
        }
    }
}
</script>
