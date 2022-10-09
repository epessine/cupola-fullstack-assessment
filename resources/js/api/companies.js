import axios from 'axios';

export default {
    async index(params) {
        const { data } = await axios.get('/api/companies', { params });

        return data;
    },
};
