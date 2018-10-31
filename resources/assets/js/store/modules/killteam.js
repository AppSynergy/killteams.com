import UUID from 'uuid/v1'

function ensureArray(value) {
    return (_.isArray(value)) ? value : [value]
}

export default {
    state: {
        killteam: {
            id: null,
            name: null,
            fighters: [],
        }
    },
    getters: {
        getKillteam: (state) => {
            return state.killteam
        },
        getName: (state) => {
            return state.killteam.name
        },
        getFighter: (state) => (fighterId) => {
            return _.find(state.killteam.fighters, { id: fighterId })
        },
        getAllFighterWargearSelectors: (state) => {
            return _.flatMap(state.killteam.fighters, (fighter) => {
                return fighter.wargearSelectors
            })
        },
        getFighterArmament: (state, getters) => ({fighterId, miniatureArmament}) => {
            const wargearSelectors = getters.getFighter(fighterId).wargearSelectors
            let armament = _.clone(miniatureArmament)
            _.each(wargearSelectors, (selector) => {
                if (selector.isSelected) {
                    _.each(ensureArray(selector.replace), (item) => {
                        _.remove(armament, x => x == item)
                    })
                    _.each(ensureArray(selector.option), (item) => {
                        armament.push(item)
                    })
                }
            })
            return armament
        },
        getFighterPoints: (state, getters, rootState, rootGetters) => ({fighterId, factionId}) => {
            const fighter = getters.getFighter(fighterId)
            const factionWargear = rootGetters.getFaction({ factionId }).wargear
            let points = fighter.miniature.points
            _.each(fighter.wargearSelectors, (selector) => {
                if (selector.isSelected) {
                    _.each(ensureArray(selector.option), (item_id) => {
                        if (item_id) {
                            let item = _.find(factionWargear, {id: item_id})
                            points += item.points
                        }
                    })
                }
            })
            return points
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
        clearKillTeam({commit}) {
            commit('clearFighters')
            commit('setId', null)
            commit('setName', '')
        },
        loadFactions({dispatch}, {factionIds}) {
            const promises = []
            for (let factionId of factionIds) {
                let promise = dispatch('fetchFaction', {factionId}, {root: true})
                promises.push(promise)
            }
            return Promise.all(promises)
        },
        loadKillteam({commit, dispatch, rootGetters}, {id, name, fighters}) {
            const factionIds = _.uniq(_.map(fighters, 'faction_id'))
            dispatch('loadFactions', {factionIds}).then(() => {
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
        addFighter({commit, rootGetters}, {fighterId, miniature, specialistSelector, wargearSelectors}) {

            if (specialistSelector) {
                if (_.isUndefined(specialistSelector.selector_id)) {
                    specialistSelector.selector_id = specialistSelector.id
                }
                specialistSelector.id = UUID()
                specialistSelector.fighter_id = fighterId
            }
            if (wargearSelectors) {
                _.each(wargearSelectors, (selector) => {
                    if (_.isUndefined(selector.selector_id)) {
                        selector.selector_id = selector.id
                    }
                    selector.id = UUID()
                    selector.fighter_id = fighterId
                })
            }
            const fighter = {
                id: UUID(),
                name: rootGetters.getFactionNarrativeName({
                    factionId: miniature.faction_id,
                    miniatureName: miniature.name,
                }),
                miniature,
                fighter_id: fighterId,
                faction_id: miniature.faction_id,
                miniature_id: miniature.id,
                armament: miniature.armament,
                points: miniature.points,
                specialistSelector,
                wargearSelectors,
            }
            commit('addFighter', fighter)
        }
    }
}
