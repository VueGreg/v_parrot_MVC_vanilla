<script setup>

    import InputText from '../../../components/tools/InputText.vue';
    import AreaText from '../../../components/tools/AreaText.vue';
    import Modal from '../../../components/ModalComponent.vue';
    import { reactive, ref } from 'vue';
    import axios from 'axios';
    import { useRouter } from 'vue-router';

    defineProps({
        data: Object
    })

    const formData = reactive({
        nom: null,
        prenom: null,
        num_telephone: null,
        mail: null,
        message: null
    })

    const errors = ref();
    const showModal = ref(false);
    const messageModal = ref();
    const router = useRouter();

    const sendMessage = async() => {
        await axios.post('http://parrotpoo.test/message', formData)
        .then(response => {
            response.data.errors ? errors.value = response.data.errors : null;
            if (response.data.code === 200) {
                showModal.value = true
                messageModal.value = response.data.message
                for (let key in formData) {
                    formData[key] = null;
                }
            }
        })
        .catch(e => {
            console.error(e);
        })
    }

    const closeModal = () => {
        showModal.value ? showModal.value = false : showModal.value = true;
        router.push('/');
    }

</script>

<template>
    <main class="row">
        <Modal :show="showModal" @close="closeModal()">
            <p>{{ messageModal }}</p>
            <button @click="closeModal()">Merci !</button>
        </Modal>
        <div class="title col-10 col-sm-7 col-md-5">
            <h2>CONTACT</h2>
            <p>Envoyez nous votre demande avec vos coordonnées, notre équipe reviendra vers vous dans les meilleurs délais.</p>
        </div>
        <form class="form col-8 col-sm-7 col-md-5">
            <Transition>
                <div class="vehicle" v-if="isVisible">
                    <!-- <p>Ma demande concerne le véhicule: <br> {{ vehicules.marque }} {{ vehicules.modele }} {{ vehicules.motorisation }}</p> -->
                </div>
            </Transition>

            <InputText for="nom" type="text" content="Votre nom" :errors="errors" v-model="formData.nom"/>
            <InputText for="prenom" type="text" content="Votre prenom" :errors="errors" v-model="formData.prenom"/>
            <InputText for="num_telephone" type="tel" content="Votre numéro de téléphone" :errors="errors" v-model="formData.num_telephone"/>
            <InputText for="mail" type="email" content="Votre adresse mail" :errors="errors" v-model="formData.mail"/>
            <AreaText for="message" type="text" content="Votre message" :errors="errors" v-model="formData.message"/>
        </form>
        <button class="col-6 col-sm-4 col-md-3" @click="sendMessage()">Envoyer message</button>
    </main>
</template>

<style lang="scss" scoped>

    @import '../../../../../scss/variable.scss';
    @import '../../../../../scss/mixins.scss';

.form {
    margin: auto;
}

h2{
    @include h2-main;
    margin-bottom: 1em;
}

button {
    @include btn-style($primary-color);
    margin-bottom: 5em;

}

.title {
    margin: auto;
}

p {
    color: $orange-formular;
    text-align: center;
    font-size: 0.8em;
    width: 100%;
}

.v-enter-active,
.v-leave-active {
transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
opacity: 0;
}

.container__modal {
    position: absolute;
    width: 100vw;
    height: 100vh;
    background-color: rgba($color: grey, $alpha: 0.4);
    z-index: 20;

    &-message {
        position: absolute;
        height: 20vh;
        width: 80vw;
        background-color: white;
        border-radius: 10px;
        box-shadow: 3px 3px 10px rgba($color: #000000, $alpha: 0.2);
        left: 10vw;
        top: 30vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    &-text {
        color: $color-text-dark;
    }

    &-button {
        border: none;
        padding: 0.5em 1em;
        border-radius: 5px;
        font-size: 0.8em;
        background-color: rgb(225, 225, 225);
        box-shadow: 2px 2px 5px rgba($color: $primary-color, $alpha: 0.2);
        margin: 0;
    }
}

@media screen and (min-width: 520px) {
    .row {
        flex-direction: column;
    }
}

</style>