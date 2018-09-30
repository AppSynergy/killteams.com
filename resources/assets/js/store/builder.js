import Vue from 'vue'
import Vuex from 'vuex'
import UUID from 'uuid/v1'
Vue.use(Vuex)

const factionsModule = {
    state: {
        factions: {},
    },
    getters: {
        getFactions: (state) => {
            return state.factions
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
        }
    }
}

const killteamModule = {
    state: {
        killteam: {
            name: 'Kill Team Name',
            fighters: [],
        }
    },
    getters: {
        getKillteam: (state) => {
            return state.killteam
        },
        getName: (state) => {
            return state.killteam.name
        }
    },
    mutations: {
        setName(state, name) {
            state.killteam.name = name
        },
        setFighters(state, fighters) {
            state.killteam.fighters = fighters
        },
        addFighter(state, fighter) {
            state.killteam.fighters.push(fighter)
        }
    },
    actions: {
        loadKillteam({commit, dispatch, rootGetters}, {name, fighters}) {
            commit('setName', name)
            _.each(fighters, (fighter) => {
                dispatch('addFighter', {
                    name: fighter.name,
                    miniature: rootGetters.getMiniature({
                        factionId: fighter.faction_id,
                        miniatureId: fighter.miniature_id,
                    })
                })
            })
        },
        addFighter(context, {name, miniature}) {
            const fighter = {
                id: UUID(),
                name,
                miniature,
                factionId: miniature.faction_id,
                miniatureId: miniature.id,
            }
            context.commit('addFighter', fighter)
        }
    }
}

export default new Vuex.Store({
    modules: {
        factionsModule, killteamModule
    }
})
