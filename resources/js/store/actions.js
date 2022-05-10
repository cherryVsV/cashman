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
    },

    ADD_COMMENT({commit}, comment) {

        return new Promise((resolve, reject) => {
            axios.post('/api/comments', comment)
                .then(response => {
                    resolve(response)
                }).catch(err => {
                reject(err)
            })
        })
    },

    GET_COMMENTS({commit}, id) {
        axios.get('/api/comments/'+id)
            .then(res => {
                {
                    commit('GET_COMMENTS', res.data)
                }
            })
            .catch(err => {
                console.log(err)
            })
    }
}

export default actions
