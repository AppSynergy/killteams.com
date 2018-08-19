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
export default {
    props: ['armament', 'factionId', 'fighterId', 'wargear', 'wgo'],
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
        },

        itemOrItemListToText(mixed, wargear, conjunction = ' or ') {
            if (_.isArray(mixed)) {
                return this.itemListToText(mixed, wargear, conjunction)
            } else {
                return this.itemToText(mixed, wargear)
            }
        },

        // copied from Tester, maybe a mixin
        itemListToText(items, wargear, conjunction = ' or ') {
            const list = _.map(items, (x) => {
                if (_.isArray(x)) {
                    return this.itemListToText(x, wargear, ' and ')
                } else {
                    return this.itemToText(x, wargear)
                }
            })
            return this.joinListWithConjunction(list, ', ', conjunction)

        },
        joinListWithConjunction(list, conjunction, final_conjunction) {
            const init = _.initial(list)
            const last = _.last(list)
            if (!_.isEmpty(init)) {
                return init.join(conjunction) + final_conjunction + last
            } else {
                return last
            }
        },
        itemToText(item_id, wargear) {
            const gear = _.find(wargear, { id: item_id })
            const name = (gear) ? gear.name : 'FAIL ITEM'
            return name
        }
    }
}
</script>
