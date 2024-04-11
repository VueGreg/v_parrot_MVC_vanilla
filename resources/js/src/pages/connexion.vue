<script setup>

    import InputText from '../components/tools/InputText.vue';
    import HeaderComponent from '../components/HeaderComponent.vue';
    import Link from '../components/LinkPOO.vue';
    import { reactive, ref } from 'vue';
    import axios from 'axios';
    import store from '../store';

    const formData = reactive({
        mail: null,
        mdp: null
    })

    const errors = ref();

    const connexion = async() => {
        await axios.post('http://parrotpoo.test/connexion', formData)
        .then(response => {
            if (response.data.isConnect) {
                store.dispatch('updateIsConnect', true);
            }

            if (response.data.errors) {
                errors.value = response.data.errors
            } else if (response.data.url) {
                window.location.href = response.data.url
            }
        })
        .catch(error => {
            console.error(error);
        });
    };

</script>

<template>
    <HeaderComponent/>
    <h2>Page de connexion</h2>
    <main class="row">
        <div class="image">
            <Link to="http://parrotpoo.test">Revenir à l'acceuil</Link>
        </div>
        <form class="form col-8 col-sm-6 col-md-5 col-lg-3" @submit.prevent="connexion">
            <InputText for="mail" type="email" content="Votre adresse mail" :errors="errors" v-model="formData.mail"/>
            <InputText for="mdp" type="password" content="Votre mot de passe" :errors="errors" v-model="formData.mdp"/>
            <input type="submit" class="form__btn col-6 col-sm-4 col-md-2 col-lg-1" value="Connexion">
        </form>
    </main>
</template>

<style lang="scss" scoped>

    @import '../../scss/variable.scss';
    @import '../../scss/mixins.scss';

    .image {
        background: url("https://gregory-wolff.com/images/slide__repair-background(3).png");
        height: 50vh;
        width: 50vh;
        padding: 2rem;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
        border-radius: 50%;
    }

    .form {
        margin: 0;
        display: flex;
        flex-direction: column;

        &__btn {
            @include btn-style($orange-formular);
            margin: 1em auto;
            margin-bottom: 5.5em;
            width: 60%;
        }
    }

    .row {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        width: 100%;
        padding: 8rem auto;
        gap: 10rem;
    }

    h2{
        @include h2-main;
    }

    @media screen and (min-width: 560px) {
        h2{
           margin-top: 3rem;
        }
    }


</style>