import Vue from 'vue'
import Vuex from 'vuex'
import UUID from 'uuid/v1'
Vue.use(Vuex)

const specialismsModule = {
    state: {
        specialisms: [],
    },
    getters: {
        getSpecialisms: (state) => {
            return state.specialisms
        }
    },
    mutations: {
        setSpecialisms(state, specialisms) {
            state.specialisms = specialisms
        }
    }
}

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

const killteamsModule = {
    state: {
        killteams: [],
    },
    getters: {
        getKillteams: (state) => {
            return state.killteams
        }
    },
    mutations: {
        setKillteams(state, killteams) {
            state.killteams = killteams
        }
    }
}

const killteamModule = {
    state: {
        killteam: {
            id: null,
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
        setId(state, id) {
            state.killteam.id = id
        },
        setName(state, name) {
            state.killteam.name = name
        },
        setFighters(state, fighters) {
            state.killteam.fighters = fighters
        },
        clearFighters(state) {
            state.killteam.fighters = []
        },
        addFighter(state, fighter) {
            state.killteam.fighters.push(fighter)
        }
    },
    actions: {
        loadKillteam({commit, dispatch, rootGetters}, {id, name, fighters}) {
            commit('clearFighters')
            commit('setId', id)
            commit('setName', name)
            _.each(fighters, (fighter) => {
                dispatch('addFighter', {
                    name: fighter.name,
                    fighterId: fighter.id,
                    miniature: rootGetters.getMiniature({
                        factionId: fighter.faction_id,
                        miniatureId: fighter.miniature_id,
                    }),

                })
            })
        },
        addFighter(context, {name, fighterId, miniature}) {
            const fighter = {
                id: UUID(),
                name,
                miniature,
                fighterId,
                factionId: miniature.faction_id,
                miniatureId: miniature.id,
                specialistSelector: {
                    id: UUID(),
                    specialism: null,
                    level: 1,
                    abilities: []
                }
            }
            context.commit('addFighter', fighter)
        }
    }
}

export default new Vuex.Store({
    modules: {
        specialismsModule, factionsModule, killteamsModule, killteamModule
    }
})
