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
            state.factions = factions
        },
        setFactionsLoaded(state, boolean) {
            state.factionsLoaded = boolean
        }
    }
}
