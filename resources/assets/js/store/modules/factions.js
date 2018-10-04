export default {
    state: {
        factions: {},
        factionsLoaded: false,
    },
    getters: {
        getFactions: (state) => {
            return state.factions
        },
        getFactionsLoaded: (state) => {
            return state.factionsLoaded
        },
        getMiniature: (state) => ({factionId, miniatureId}) => {
            const faction = _.find(state.factions, {
                id: factionId
            })
            const datasheet = _.find(faction.datasheets, {
                miniatures: [{ id: miniatureId }],
            })
            const miniature = _.find(datasheet.miniatures, {
                id: miniatureId,
            })
            return miniature
        }
    },
    mutations: {
        setFactions(state, factions) {
            factions = _.map(factions, (faction) => {
                faction.full = false
                return faction
            })
            state.factions = factions
        },
        setFactionsLoaded(state, boolean) {
            state.factionsLoaded = boolean
        },
        setFaction(state, faction) {
            faction.full = true
            const faction_index = _.findIndex(state.factions, { id: faction.id })
            Vue.set(state.factions, faction_index, faction)
            console.log("Faction set in state", faction.id)
        }
    },
    actions: {
        async fetchFaction({commit}, {faction_id}) {
            return new Promise((resolve, reject) => {
                axios.get(API_URL + '/factions/' + faction_id).then(response => {
                    const faction = response.data.data
                    commit('setFaction', faction)
                    console.log("fetched Faction", faction_id, faction)
                    resolve()
                })
            })
        },
    }
}
