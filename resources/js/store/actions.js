let actions = {
    SEARCH_COMPANIES({commit}, query) {
        let params = {
            query
        };
        axios.get('api/search', {params})
            .then(res => {
                if (res.data === 'ok')
                    console.log('request sent successfully')

            }).catch(err => {
            console.log(err)
        })
    },
    GET_COMPANIES({commit}) {
        axios.get('api/companies')
            .then(res => {
                {
                    commit('SET_COMPANIES', res.data)
                }
            })
            .catch(err => {
                console.log(err)
            })
    }
}

export default actions
