export default {
    methods: {
        itemOrItemListToText(mixed, wargear, conjunction = ' or ') {
            if (_.isArray(mixed)) {
                return this.itemListToText(mixed, wargear, conjunction)
            } else {
                return this.itemToText(mixed, wargear)
            }
        },

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
