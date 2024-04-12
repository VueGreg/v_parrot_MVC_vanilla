
import { ref } from 'vue';
import createApiWithCsrfToken from '../../../axios';

export default function useTemoignage()
{
    const responseData  = ref();
    const errors = ref();
    const api = createApiWithCsrfToken();

    async function changeStatus(id) {
        try {
            const api = await createApiWithCsrfToken();
            const response = await api.put('/dashboard/temoignage', id);
            responseData.value = response.data;
            if (response.data.error) {
                console.log(response.data.error);
            }
        } catch (error) {
            console.error(error);
        }
    }

    async function deleteStatus(id) {
        try {
            const api = await createApiWithCsrfToken();
            const response = await api.delete('/dashboard/temoignage', { params: { id: id } });
            responseData.value = response.data;
            if (response.data.error) {
                console.log(response.data.error);
            }
        } catch (error) {
            console.error(error);
        }
    }

    return {
        deleteStatus,
        changeStatus,
        responseData,
        errors
    }
}