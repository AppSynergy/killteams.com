export default {
    state: {
        factions: [],
    },
    getters: {
        getFactions: (state) => {
            return state.factions
        },
        getFaction: (state) => ({factionId}) => {
            const faction = _.find(state.factions, { id: factionId })
            return faction
        },
        getFactionFullyLoaded: (state, getters) => ({factionId}) => {
            const faction = getters.getFaction({factionId})
            return faction.fullyLoaded
        },
        getMiniature: (state, getters) => ({factionId, miniatureId}) => {
            const faction = getters.getFaction({factionId})
            const datasheet = _.find(faction.datasheets, { miniatures: [{ id: miniatureId }]})
            return _.find(datasheet.miniatures, { id: miniatureId })
        },
        getFactionNarrativeName: (state, getters) => ({factionId, miniatureName}) => {
            const faction = getters.getFaction({factionId})
            if (_.has(faction.narrative, 'names')) {
                const names = faction.narrative.names
                return _.sample(names.forename) + ' ' + _.sample(names.surname)
            }
            return miniatureName
        },
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
        fetchFaction({getters, commit}, {factionId}) {
            return new Promise((resolve, reject) => {
                if (!getters.getFactionFullyLoaded({factionId})) {
                    axios.get(API_URL + '/factions/' + factionId).then(response => {
                        commit('setFaction', response.data.data)
                        resolve(factionId)
                    })
                } else {
                    resolve(factionId)
                }
            })
        },
    }
}
