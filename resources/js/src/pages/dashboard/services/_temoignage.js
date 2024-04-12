
import { ref } from 'vue';
import axios from 'axios';

export default function useTemoignage()
{
    const responseData  = ref();
    const errors = ref();

    const changeStatus = async(id) => {
        await axios.put('http://parrotpoo.test/dashboard/temoignage', id)
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

    const deleteStatus = async(id) => {
        await axios.delete('http://parrotpoo.test/dashboard/temoignage', { params: { id: id } })
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