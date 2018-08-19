<template>
    <div class="vue-builder-home">
        <div class="container">
            <div class="card p-4 my-4" v-for="faction, i in factionDataSorted" :key="i">
                <span class="h1 mb-3 font-weight-bold text-uppercase">
                    {{ faction.name }}
                </span>
                <div class="card mb-5 p-3 bg-dark text-light" v-for="datasheet in faction.datasheets">
                    <span class="h2 mb-2 font-weight-bold">
                        {{ datasheet.name }}
                    </span>
                    <small>{{ datasheet.keywords.join(' &middot; ') }}</small>
                    <small>{{ datasheet.abilities.join(' &middot; ') }}</small>
                    <div class="card body text-dark my-3 p-3" v-for="mini in datasheet.miniatures">
                        <span class="h3 mb-2 d-flex justify-content-between align-items-center">
                            <span class="w-50">
                                <span class="font-weight-bold">{{ mini.name }}</span>
                                <span class="badge badge-info">{{ mini.points }}</span>
                            </span>
                            <span class="w-50">
                                <table class="table table-sm table-bordered">
                                    <thead class="thead-dark"><tr>
                                        <th class="text-center"
                                            v-for="_, key in mini.profile">{{ key }}</th>
                                    </tr></thead>
                                    <tbody><tr>
                                        <td class="text-center"
                                            v-for="val in mini.profile">{{ val }}</td>
                                    </tr></tbody>
                                </table>
                            </span>
                        </span>
                        <span class="alert alert-info"
                            v-html="armamentToText(mini.armament, faction.wargear)">
                        </span>
                        <span class="alert alert-success"
                            v-for="wgo in mini.wargear_options"
                            v-html="wargearOptionToText(wgo, faction.wargear)">
                        </span>
                        <span class="alert alert-warning">
                            {{ mini.specialists.join(' &middot; ') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="sass">
    .table td, .badge
        font-family: Courier
    .alert
        font-size: 110%
</style>

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
            const name = (gear) ? gear.name : 'FAIL ITEM'
            const points = (gear) ? gear.points : 9001
            return name + ' <span class="badge badge-info">' + points + '</span>'
        }
    }
}
</script>
