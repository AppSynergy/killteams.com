<template>
    <span class="vue-builder-fighter">

        <span class="h3 mb-2 d-flex justify-content-between align-items-center">
            <span class="">
                <span class="font-weight-bold">{{ fighter.name }}</span>
                <span class="badge badge-info">{{ fighter.points }}</span>
            </span>
            <span class="">
                <table class="table table-sm table-bordered">
                    <thead class="thead-dark"><tr>
                        <th class="text-center"
                            v-for="_, key in fighter.profile">{{ key }}</th>
                    </tr></thead>
                    <tbody><tr>
                        <td class="text-center"
                            v-for="val in fighter.profile">{{ val }}</td>
                    </tr></tbody>
                </table>
            </span>
        </span>

        <span class="alert alert-info d-block">
            <strong>Armed with:</strong> <em
                v-html="armamentToText(finalArmament, faction.wargear)"></em><br>
        </span>

        <span class="alert alert-success d-block"
            v-if="hasWargearOptions">
            <wargear-selector
                v-for="wgo, wgo_i in fighter.wargear_options"
                :key="wgo_i"
                :faction-id="faction.id"
                :fighter-id="fighter.id"
                :armament="fighter.armament"
                :wgo="wgo"
                :wargear="faction.wargear"
                v-on:selectWargear="selectWargear"
            ></wargear-selector>
            <em class="pr-2 d-block" v-for="wgo in fighter.wargear_options"
                v-html="wargearOptionToText(wgo, faction.wargear)"></em>
        </span>

        <span class="alert alert-warning d-block">
            {{ fighter.specialists.join(' &middot; ') }}
        </span>

    </span>
</template>

<script>
import itemsToText from '../../mixins/itemsToText.js'
import WargearSelector from './WargearSelector.vue'
export default {
    components: {
        WargearSelector
    },
    mixins: [
        itemsToText
    ],
    props: [
        'faction', 'fighterInit'
    ],
    data() {
        return {
            wargearMasks: []
        }
    },
    computed: {
        fighter() {
            return _.clone(this.fighterInit)
        },
        finalArmament() {
            let armament = _.clone(this.fighter.armament)
            _.each(this.wargearMasks, (mask) => {
                armament = this.applyWargearMask(armament, mask)
            })
            return armament
        },
        hasWargearOptions() {
            return !_.isEmpty(this.fighter.wargear_options)
        }
    },
    methods: {
        armamentToText(armament, wargear) {
            return this.itemListToText(armament, wargear, ' and ')
        },
        wargearOptionToText(wargear_option, wargear) {
            let out = ''
            if (wargear_option.replace) {
                const items = this.itemListToText(wargear_option.replace, wargear, ' and ')
                out += 'Replace ' + items + ' with '
            } else {
                out += 'Take '
            }
            if (wargear_option.options) {
                const items = this.itemListToText(wargear_option.options, wargear, ' or ')
                out += items
            } else {
                out += "FAIL ITEMS"
            }
            return out
        },
        applyWargearMask(armament, mask) {
            _.each(mask.replace_items, (item) => {
                _.remove(armament, x => x == item)
            })
            _.each(mask.add_items, (item) => {
                armament.push(item)
            })
            return armament
        },
        selectWargear(selection) {
            const replace = (_.isArray(selection.replace)) ? selection.replace : [selection.replace]
            const option = (_.isArray(selection.option)) ? selection.option : [selection.option]
            // clear previous masks
            this.wargearMasks = _.reject(this.wargearMasks, { selection_id: selection.selection_id })
            // add to masks
            if (selection.isSelected) {
                this.wargearMasks.push({
                    selection_id: selection.selection_id,
                    replace_items: replace,
                    add_items: option,
                })
            }
        }

    }
}
</script>
