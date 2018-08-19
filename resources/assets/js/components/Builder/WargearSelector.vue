<template>
    <div class="vue-builder-wargear-selector">
        <span class="form-check form-inline">

            <input type="checkbox" class="form-check-input">

            <span v-if="'REPLACE' == wgo.may">
                Replace {{ itemListToText(wgo.replace, wargear, ' and ') }}
                with&nbsp;
            </span>

            <span v-if="'TAKE' == wgo.may">
                Take&nbsp;
            </span>

            <span v-if="'ALLOF' == wgo.method">
                {{ itemListToText(wgo.options, wargear, ' and ') }}
            </span>

            <span v-if="'ONEOF' == wgo.method">
                <select class="form-control ml-2">
                    <option v-for="choice in wgo.options" :value="choice">
                        {{ itemToText(choice, wargear) }}
                    </option>
                </select>
            </span>

        </span>
    </div>
</template>

<script>
export default {
    props: ['armament', 'wargear', 'wgo'],
    methods: {
        // copied from Tester, maybe a mixin
        itemListToText(armament, wargear, conjunction = ' or ') {
            const list = _.map(armament, (x) => {
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
