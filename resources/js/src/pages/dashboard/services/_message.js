
import { ref } from 'vue';
import createApiWithCsrfToken from '../../../axios';

export default function useMessage()
{
    const responseData  = ref();
    const errors = ref();
    const api = createApiWithCsrfToken();

    async function checkMessage(id) {
        try {
            const api = await createApiWithCsrfToken();
            const response = await api.put('/dashboard/message', id);
            console.log(response)
            responseData.value = response.data;
            if (response.data.error) {
                console.log(response.data.error);
            }
        } catch (error) {
            console.error(error);
        }
    }

    return {
        checkMessage,
        responseData,
        errors
    }
}