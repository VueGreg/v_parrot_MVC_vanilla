<script setup>
    import Link from '../components/LinkPOO.vue';
    import { computed } from 'vue';
    import axios from 'axios';

    const props = defineProps({
        isConnect: Boolean
    });

    const logout = async () => {
        try {
            const response = await axios.get('http://parrotpoo.test/deconnexion');
            if (response.data.isConnect) {
                localStorage.removeItem('_csrf');
            }
            if (response.data.url) {
                window.location.href = response.data.url;
            }
        } catch (error) {
            console.error(error);
        }
    };
</script>

<template>

    <header>
        <LinkPOO to="/" style="text-decoration: none;">
            <div class="logo">
                <img class="logo__image" src="https://gregory-wolff.com/images/wepik-geometric-gradient-brandname-logo-20230927155932MPVN.png" alt="Logo de l'entreprise Vincent PARROT">
                <p class="logo__text">GARAGE V.PARROT</p>
            </div>
        </LinkPOO>

        <div class="button">
            <!--Call btn-->
            <a class="button__header" href="#">
                <div class="button__header-circle">
                    <i class="fa-solid fa-phone" style="color: #ffffff;"></i>
                </div>
                <p class="button__header-text">Appeler</p>
            </a>

            <!--Schedule btn-->
            <a class="button__header" href="#">
                <div class="button__header-circle">
                    <i class="fa-solid fa-clock" style="color: #ffffff;"></i>
                </div>
                <p class="button__header-text">Horaires</p>
            </a>

            <!--Connection btn-->
            <div class="navigate-link button__header" v-if="isConnect" @click.prevent="logout()">
                <div class="button__header-circle">
                    <i class="fa-solid fa-arrow-right-to-bracket" style="color: #ffffff;"></i>
                </div>
                <p class="button__header-text">Déconnexion</p>
            </div>
            <Link class="navigate-link button__header" to="http://parrotpoo.test/connexion" v-else>
                <div class="button__header-circle">
                    <i class="fa-solid fa-arrow-right-to-bracket" style="color: #ffffff;"></i>
                </div>
                <p class="button__header-text">Connexion</p>
            </Link>
        </div>
    </header>

</template>


<style lang="scss" scoped>
    @import '../../../scss/variable.scss';
    @import '../../../scss/mixins.scss';

    header {
        background-color: $dark-grey;
        height: 16vh;
    }
    .logo{
        @include flex-center;

            &__image{
                height: 75px;
                width: auto;
            }

            &__text{
                color: white;
                font-family: $font-text-nav-card;
                font-weight: 600;
                font-size: 1.4em;
            }
    }

    .button{
        display: flex;
        justify-content: space-around;
        align-items: center;

        &__header{
            @include flex-center;
            width: 30vw;
            text-decoration: none;

            &-circle{
                border-radius: 50%;
                background-color: $primary-color;
                height: 30px;
                width: 30px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            &-text{
                color: #a3a3a3;
                font-family: $font-text-primary;
                font-size: 1em;
                font-weight: 600;
                margin-left: 0.5em;
                margin-top: 0.8em;
            }
        }
    }

    .navigate-link {
        text-decoration: none;
        cursor: pointer;
    }

    @media screen and (min-width: 580px) {

        header {
            height: 12vh;
        }
        
        .button__header-text {
            margin: 0;
            margin-left: 0.5em;
        }
    }

    @media screen and (min-width: 960px) {

        header {
            height: 8vh;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .button {

            width: 45vw;
        }
    }
</style>./LinkPOO.vue
