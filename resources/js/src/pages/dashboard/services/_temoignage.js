
import { ref } from 'vue';
import api from '../../../axios';

export default function useTemoignage()
{
    const responseData  = ref();
    const errors = ref();

    const changeStatus = async(id) => {
        await api.put('/dashboard/temoignage', id)
        .then(response => {
            console.log(response.data)
            responseData.value = response.data;
            if (response.data.error) {
                console.log(response.data.error);
            }
        })
        .catch(e => {
            console.error(e);
        })
    }

    const deleteStatus = async(id) => {
        await api.delete('/dashboard/temoignage', { params: { id: id } })
        .then(response => {
            responseData.value = response.data;
            if (response.data.error) {
                console.log(response.data.error);
            }
        })
        .catch(e => {
            console.error(e);
        })
    }

    return {
        deleteStatus,
        changeStatus,
        responseData,
        errors
    }
}