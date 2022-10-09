import axios from 'axios';

export default {
    async index(params) {
        const { data } = await axios.get('/api/cities', { params });

        return data;
    },
};
