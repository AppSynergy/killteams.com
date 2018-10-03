export default {
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
