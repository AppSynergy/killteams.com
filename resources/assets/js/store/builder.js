import Vue from 'vue'
import Vuex from 'vuex'
import UUID from 'uuid/v1'
Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        factions: {},
        killteam: {
            name: 'Kill Team Name',
            faction_id: null,
            fighters: [],
        }
    },
    getters: {
        getFactions: (state) => {
            return state.factions
        },
        getFaction: (state) => (factionId) => {
            return state.factions[factionId]
        },
        getFighters: (state) => {
            return state.killteam.fighters
        },
    },
    actions: {

    },
    mutations: {
        setFactions(state, factions) {
            state.factions = factions
        },
        setFighters(state, fighters) {
            state.killteam.fighters = fighters
        },
    }
})
