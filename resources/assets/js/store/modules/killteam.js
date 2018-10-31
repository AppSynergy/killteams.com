import UUID from 'uuid/v1'

function ensureArray(value) {
    return (_.isArray(value)) ? value : [value]
}

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
        },
        getFighter: (state) => (fighterId) => {
            return _.find(state.killteam.fighters, { id: fighterId })
        },
        getAllFighterWargearSelectors: (state) => {
            return _.flatMap(state.killteam.fighters, (fighter) => {
                return fighter.wargearSelectors
            })
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
        },
        updateArmament(state, {fighterId, miniatureArmament}) {
            const fighterIndex = _.findIndex(state.killteam.fighters, { id: fighterId })
            const wargearSelectors = state.killteam.fighters[fighterIndex].wargearSelectors
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
            state.killteam.fighters[fighterIndex].armament = armament
        }
    },
    actions: {
        updateWargearSelector({commit, state}, payload) {
            commit('updateWargearSelector', payload)
            commit('updateArmament', payload)
        },
        clearKillTeam({commit}) {
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
                        faction_id: fighter.faction_id,
                        miniature_id: fighter.miniature_id,
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
                armament: miniature.armament,
                specialistSelector,
                wargearSelectors,
            }
            context.commit('addFighter', fighter)
        }
    }
}
