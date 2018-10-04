export default {
    state: {
        factions: [],
    },
    getters: {
        getFactions: (state) => {
            return state.factions
        },
        getFactionFullyLoaded: (state) => ({faction_id}) => {
            const faction = _.find(state.factions, { id: faction_id })
            return faction.fullyLoaded
        },
        getMiniature: (state) => ({faction_id, miniature_id}) => {
            const faction = _.find(state.factions, { id: faction_id })
            const datasheet = _.find(faction.datasheets, { miniatures: [{ id: miniature_id }]})
            return _.find(datasheet.miniatures, { id: miniature_id })
        }
    },
    mutations: {
        setFactions(state, factions) {
            factions = _.map(factions, (faction) => {
                faction.fullyLoaded = false
                return faction
            })
            state.factions = factions
        },
        setFactionsLoaded(state, boolean) {
            state.factionsLoaded = boolean
        },
        setFaction(state, faction) {
            faction.fullyLoaded = true
            const faction_index = _.findIndex(state.factions, { id: faction.id })
            Vue.set(state.factions, faction_index, faction)
        }
    },
    actions: {
        fetchFactions({commit}) {
            return new Promise((resolve, reject) => {
                axios.get(API_URL + '/factions').then(response => {
                    commit('setFactions', response.data.data)
                    resolve()
                })
            })
        },
        fetchFaction({getters, commit}, {faction_id}) {
            return new Promise((resolve, reject) => {
                if (!getters.getFactionFullyLoaded({faction_id})) {
                    axios.get(API_URL + '/factions/' + faction_id).then(response => {
                        commit('setFaction', response.data.data)
                        resolve(faction_id)
                    })
                } else {
                    resolve(faction_id)
                }
            })
        },
    }
}
