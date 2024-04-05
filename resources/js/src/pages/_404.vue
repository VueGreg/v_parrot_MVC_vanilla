<script setup>

    import LinkPOO from '../components/LinkPOO.vue';

</script>


<template>
    <div class="error error-img">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <h1>Erreur 404</h1>
        <h2>page non trouvée</h2>
        <LinkPOO to="/" class="error-link">Revenir à l'Acceuil</LinkPOO>
    </div>
</template>

<style lang="scss" scoped>

    @import '../../scss/variable.scss';
    @import '../../scss/mixins.scss';

    .error-img {
        background: url("https://gregory-wolff.com/images/198373918_l_normal_none 1(5).png");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: top center;
        height: 100vh;
    }

    .error {
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-shadow: 3px 3px 8px rgba($color: #000000, $alpha: 0.8);

        & i {
            font-size: 6em;
        }

        & h1 {
            font-size: 5em;
        }

        & h2 {
            font-size: 3em;
        }

        &-link {
            font-size: 3rem;
            color: white;
            background-color: $primary-color;
            border-radius: 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
            box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.45);
            margin: 2rem;
        }
    }

</style>