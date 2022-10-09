import axios from 'axios';

export default {
    async index() {
        const { data } = await axios.get('/api/states');

        return data;
    },
};
