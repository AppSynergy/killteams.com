import UUID from 'uuid/v1'

export default {
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
        clearAll({commit}) {
            commit('clearFighters')
            commit('setId', null)
            commit('setName', '')
        },
        loadFactions({dispatch}, {faction_ids}) {
            const promises = []
            for (let faction_id of faction_ids) {
                let promise = dispatch('fetchFaction', {faction_id}, {root: true})
                promises.push(promise)
            }
            return Promise.all(promises)
        },
        loadKillteam({commit, dispatch, rootGetters}, {id, name, fighters}) {
            const faction_ids = _.uniq(_.map(fighters, 'faction_id'))
            dispatch('loadFactions', {faction_ids}).then(() => {
                commit('clearFighters')
                commit('setId', id)
                commit('setName', name)
                _.each(fighters, (fighter) => {
                    const miniature = rootGetters.getMiniature({
                        factionId: fighter.faction_id,
                        miniatureId: fighter.miniature_id,
                    })
                    fighter.wargearSelectors = _.map(fighter.wargearSelectors, (selector, index) => {
                        selector.wgo = miniature.wargear_options[index]
                        return selector
                    })
                    dispatch('addFighter', {
                        name: fighter.name,
                        fighterId: fighter.id,
                        miniature,
                        specialistSelector: fighter.specialistSelector,
                        wargearSelectors: fighter.wargearSelectors,
                    })
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
