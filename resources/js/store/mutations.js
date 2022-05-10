let mutations = {
    SET_COMPANIES(state, companies) {
        state.companies = companies
    },
    GET_COMMENTS(state, comments) {
        state.comments = comments
    },
    ADD_COMMENT(state, comment) {
        state.comments = [...state.comments, comment]
    }
}

export default mutations
