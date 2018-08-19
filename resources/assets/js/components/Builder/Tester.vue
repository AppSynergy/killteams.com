<template>
    <div class="vue-builder-home">
        <div class="container">
            <div class="card p-4 my-4" v-for="faction, i in factionDataSorted" :key="i">
                <span class="h2 mb-3 font-weight-bold text-uppercase">
                    {{ faction.name }}
                </span>
                <div class="card mb-2 p-3" v-for="datasheet in faction.datasheets">
                    <span class="h3 mb-2 font-weight-bold">
                        {{ datasheet.name }}
                    </span>
                    <div class="card body my-3 p-2" v-for="mini in datasheet.miniatures">
                        <span class="h4 mb-2">
                            {{ mini.name }}
                        </span>
                        <span class="alert alert-info">
                            {{ armamentToText(mini.armament, faction.wargear) }}
                        </span>
                        <span class="alert alert-success" v-for="wgo in mini.wargear_options">
                            {{ wargearOptionToText(wgo, faction.wargear) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            factionData: []
        }
    },
    mounted() {
        axios.get(API_URL + '/factions').then(response => {
            this.$store.commit('setFactions', response.data.data)
            _.each(this.factions, (f) => {
                axios.get(API_URL + '/factions/' + f.id).then(response => {
                    this.factionData.push(response.data.data)
                })

            })
        })
    },
    computed: {
        factionDataSorted() {
            return _.sortBy(this.factionData, 'id')
        },
        factions() {
            return this.$store.getters.getFactions
        },
    },
    methods: {
        wargearOptionToText(wargear_option, wargear) {
            let out = ''
            if (wargear_option.replace) {
                const items = this.itemListToText(wargear_option.replace, wargear, 'and')
                out += "Replace " + items + ' with '
            } else {
                out += "Take "
            }
            if (wargear_option.options) {
                const items = this.itemListToText(wargear_option.options, wargear, 'or')
                out += items
            } else {
                out += "FAIL ITEMS"
            }
            return out
        },
        armamentToText(armament, wargear) {
            return this.itemListToText(armament, wargear, 'and')
        },
        itemListToText(armament, wargear, conjunction = 'or') {
            const arr = _.map(armament, (x) => {
                if (_.isArray(x)) {
                    return this.itemListToText(x, wargear, 'and')
                } else {
                    return this.itemToText(x, wargear)
                }
            })
            return arr.join(' ' + conjunction + ' ')
        },
        itemToText(item_id, wargear) {
            const gear = _.find(wargear, { id: item_id })
            if (gear) return gear.name
            else return "FAIL ITEM"
        }
    }
}
</script>
