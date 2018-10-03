import Vue from 'vue'
import Vuex from 'vuex'
import UUID from 'uuid/v1'
Vue.use(Vuex)

const specialismsModule = {
    state: {
        specialisms: [],
        specialismsLoaded: false,
    },
    getters: {
        getSpecialisms: (state) => {
            return state.specialisms
        },
        getSpecialismsLoaded: (state) => {
            return state.specialismsLoaded
        }
    },
    mutations: {
        setSpecialisms(state, specialisms) {
            state.specialisms = specialisms
        },
        setSpecialismsLoaded: (state, boolean) => {
            state.specialismsLoaded = boolean
        }
    }
}

const factionsModule = {
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

const killteamsModule = {
    state: {
        killteams: [],
        killteamsLoaded: false,
    },
    getters: {
        getKillteams: (state) => {
            return state.killteams
        },
        getKillteamsLoaded: (state) => {
            return state.killteamsLoaded
        }
    },
    mutations: {
        setKillteams(state, killteams) {
            state.killteams = killteams
        },
        setKillteamsLoaded(state, boolean) {
            state.killteamsLoaded = boolean
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
        },
        removeFighter(state, fighterId) {
            state.killteam.fighters = _.reject(state.killteam.fighters, (fighter) => {
                return fighter.id == fighterId
            })
        },
        updateSpecialistSelector(state, {fighterId, selector}) {
            const fighterIndex = _.findIndex(state.killteam.fighters, { id: fighterId })
            state.killteam.fighters[fighterIndex].specialistSelector = selector
        },
        updateWargearSelector(state, {fighterId, selectorId, selector}) {
            const fighterIndex = _.findIndex(state.killteam.fighters, { id: fighterId })
            const selectorIndex = _.findIndex(state.killteam.fighters[fighterIndex].wargearSelectors, { id: selectorId })
            state.killteam.fighters[fighterIndex].wargearSelectors[selectorIndex] = selector
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
                    specialistSelector: fighter.specialistSelector,
                    wargearSelectors: fighter.wargearSelectors,
                })
            })
        },
        addFighter(context, {name, fighterId, miniature, specialistSelector, wargearSelectors}) {
            if (specialistSelector) {
                specialistSelector.selector_id = specialistSelector.id
                specialistSelector.id = UUID()
                specialistSelector.fighter_id = fighterId
            }
            if (wargearSelectors) {
                _.each(wargearSelectors, (selector) => {
                    selector.selector_id = selector.id
                    selector.id = UUID()
                    selector.fighter_id = fighterId
                })
            }
            const fighter = {
                id: UUID(),
                name,
                miniature,
                fighter_id: fighterId,
                faction_id: miniature.faction_id,
                miniature_id: miniature.id,
                specialistSelector,
                wargearSelectors,
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
