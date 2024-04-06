import axios from 'axios';
import { ref } from 'vue';

export default function useFilterForm () {

    const baseFilter = ref({});

    const getBaseFilter = async() => {
        await axios.get('http://parrotpoo.test/filtre')
        .then(response => {
            baseFilter.value = response.data;
        })
        .catch(e => {
            console.error(e);
        })
    }

    return {
        baseFilter,
        getBaseFilter
    }

}