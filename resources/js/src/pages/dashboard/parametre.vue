<script setup>

    import LayoutView from '../../Layout/LayoutView.vue';
    import Input from '../../components/tools/InputText.vue';
    import { reactive } from 'vue';

    const props = defineProps({
        data: Object
    })

    const formData = reactive({
        adresse: props.data.informations.adresse,
        code_postal: props.data.informations.code_postal,
        ville: props.data.informations.ville,
        num_telephone: props.data.informations.num_telephone,
    })

</script>

<template>
    <LayoutView>
        <template #content>
        <main id="top">
            <section class="row" v-for="information in data.informations">
                <h2>INFORMATIONS GENERALE</h2>
                <div class="title">
                    <div class="title__logo">
                        <img :src="information.adresse_logo" alt="">
                        <p>GARAGE V.PARROT</p>
                    </div>
                </div>
                <form class="form col-9 col-xl-6">
                    <div class="form__input">
                        <Input for="adresse" type="text" :content="information.adresse" v-model="formData.adresse"/>
                        <label class="form__label" for="adresse">Adresse</label>
                    </div>
                    <div class="form__group">
                        <div class="form__input col-5">
                            <Input for="code_postal" type="text" :content="information.code_postal" v-model="formData.code_postal"/>
                            <label class="form__label" for="postal_code">Code postal:</label>
                        </div>
                        <div class="form__input col-5">
                            <Input for="ville" type="text" :content="information.ville" v-model="formData.ville"/>
                            <label class="form__label" for="city">Ville:</label>
                        </div>
                    </div>
                    <div class="form__input">
                        <Input for="num_telephone" type="tel" :content="information.num_telephone" v-model="formData.num_telephone"/>
                        <label class="form__label" for="tel">Numéro de téléphone:</label>
                    </div>
                    <div class="form__input">
                        <Input for="mail" type="email" :content="information.mail" v-model="formData.mail"/>
                        <label class="form__label" for="email">E-mail:</label>
                    </div>
                    <button type="button" @click="changeBusinessSetting()">Modifier les informations</button>
                </form>
            </section>
            <section class="row">
                <h2>HORAIRES D'OUVERTURE</h2>
                <table class="col-9 col-xl-4">
                    <tr v-for="horaire in data.horaires" :key="horaire.id">
                        <td>{{ horaire.jour_semaine }}</td>
                        <td>
                            <div class="form__input">
                                <label class="form__label" :for="horaire.jour_semaine + 'Debut'">Début</label>
                                <!-- <select :name="horaire.jour_semaine + 'Debut'" :id="horaire.jour_semaine + 'Debut'" v-model="horaireChange[horaire.id].debut">
                                    <option>{{ horaireChange[horaire.id].debut }}</option>
                                    <option v-for="heure in horaire.list" :key="heure.id">{{ heure }}</option>
                                </select> -->
                            </div>
                        </td>
                        <td>
                            <div class="form__input">
                                <label class="form__label" :for="horaire.jour_semaine + 'Fin'">Fin</label>
                                <!-- <select :name="horaire.jour_semaine + 'Fin'" :id="horaire.jour_semaine + 'Fin'" v-model="horaireChange[horaire.id].fin">
                                    <option>{{ horaireChange[horaire.id].fin }}</option>
                                    <option v-for="heure in horaire.list" :key="heure.id">{{ heure }}</option>
                                </select> -->
                            </div>
                        </td>
                    </tr>
                </table>
                <button type="button" class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1" @click="sendHoraires()">Envoyer les modifications</button>
            </section>
            <section>
                <h2>REPARATIONS</h2>
                <a href="#form">
                    <button class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1">
                        <i class="fa-solid fa-plus"></i>
                        <span>  AJOUTER</span>
                    </button>
                </a>
                <div class="message col-9 col-xl-4" v-for="reparation in data.reparations" :key="reparation.id" @click="showOptions(reparation.id)">
                    <div class="message__element">
                        <p class="message__element-title">Catégorie:</p>
                        <p class="message__element-result">{{ reparation.categorie }}</p>
                    </div>
                    <div class="message__element-bis">
                        <p class="message__element-title">Description:</p>
                        <p>{{ reparation.description }}</p>
                    </div>
                    <div class="message__element none" :class="{ active: reparation.id === activeItem }">
                        <button @click="deleteRepair($event, reparation.id)">
                            <i class="fa-solid fa-trash"></i>
                            <span>  Supprimer</span>
                        </button>
                        <button>
                            <i class="fa-solid fa-pen-to-square"></i>
                            <span>  Modifier</span>
                        </button>
                    </div>
                </div>
                <!-- <div class="message form col-9 col-xl-4" id="form">
                    <h6>Ajouter une prestation</h6>
                    <div class="form__input">
                        <label class="form__label" for="categorie">Catégorie</label>
                        <select name="categorie" id="categorie" v-model="models.categorie">
                            <option :value="categorie.categorie" v-for="categorie in categories">{{ categorie.categorie }}</option>
                        </select>
                    </div>
                    <div class="form__input">
                        <textarea class="form__field" v-model="models.description" name="description" id="description" placeholder="Description"></textarea>
                        <label class="form__label" for="description">Description</label>
                    </div>
                    <button class="col-6 col-sm-4 col-md-3 col-lg-2" @click="sendRepair($event)">AJOUTER</button>
                </div> -->
            </section>
            <button class="top-page">
                <a href="#top">
                    <i class="fa-solid fa-arrow-up"></i>
                </a>
            </button>
        </main>
        </template>
    </LayoutView>
</template>

<style lang="scss" scoped>

    @import '../../../../scss/variable.scss';
    @import '../../../../scss/mixins.scss';

    h2 {
        @include h2-main;
    }

    table {
        margin: auto;

        & tr {
            vertical-align: bottom;
        }
        
        & td {
            padding: 0.5em
        }
    }

    h6 {
        text-align: center;
        margin: 2em;
    }

    select {
        border: none;
        border-bottom: 2px solid $orange-formular;
        color: $orange-formular;
        text-align: end;
        background: none;
        font-size: 0.8em;
    }

    button {
        @include btn-style($primary-color);
    }

    a {
        text-decoration: none;
    }

    .title {
        &__logo {
            @include flex-center;

            & img {
                height: 5em;
                width: auto;
            }
        }
    }

    .form {
        margin: auto;

    &__input {
        display: flex;
        flex-direction: column;
        color: $orange-formular;
        position: relative;
        padding: 8px 0 0;
        margin-top: 10px;

        &-alert {
            position: relative;
            top: -3em;
            width: 100%;
            text-align: start;
            font-size: 0.6em;
            display: block;
            margin: 0 auto;
            color: red;
            padding-left: 0.2em;
        }
    }
    & p {
        font-size: 1.1em;
        margin-top: 1em;
    }
    &__group {
        @include flex-center;
        justify-content: space-between;
    }
    }

    .form__field {
        font-family: inherit;
        border: 0;
        width: 100%;
        border-bottom: 2px solid $orange-formular;
        outline: 0;
        font-size: 0.8em;
        color: $orange-formular;
        padding: 7px 0;
        background: transparent;
        transition: border-color 0.2s;
        margin: 0.2em auto;
        margin-bottom: 3em;

        &::placeholder {
            color: transparent;
        }

        &:placeholder-shown ~ .form__label {
            font-size: 0.8em;
            cursor: text;
            top: 20px;
        }
    }

    .form__label {
        position: absolute;
        top: 0;
        display: block;
        transition: 0.2s;
        font-size: 0.8em;
        color: $orange-formular;
    }

    .form__field:focus {
        ~ .form__label {
            position: absolute;
            top: 0;
            display: block;
            transition: 0.2s;
            font-size: 0.9em;
            color: $primary-color;
            font-weight:700;    
        }

        padding-bottom: 6px;  
        font-weight: 700;
        border-width: 3px;
        border-image: linear-gradient(to right, $orange-formular, $primary-color);
        border-image-slice: 1;
    }

    /* reset input */
        .form__field{
        &:required,&:invalid { box-shadow:none; }
    }

    .message{
        border-radius: 5px;
        box-shadow: 3px 3px 8px rgba($color: #000000, $alpha: 0.4);
        margin: 1em auto;
        padding: 1em;

        &__element {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8em;

            &-title {
                font-weight: 600;
            }

            &-result {
                color: $primary-color;
                font-weight: 600;
            }

            &-bis {
                font-size: 0.8em;
            }
        }

        &__text {
            font-size: 0.8em;
        }

        &__option {
            display: flex;
            justify-content: space-around;
            align-items: center;
            border-top: 1px solid rgba($color: #000000, $alpha: 0.8);
            padding-top: 1.5em;

            &-btn {
                border: 2px solid $primary-color;

                & i {
                    color: $primary-color;
                    padding: 1em;
                }

                &:hover {
                    border: none;
                    background-color: $primary-color;

                    & i {
                        color: white;
                    }
                }
            }
        }
    }

    .form {
        margin: auto;
        margin-bottom: 3em;

        &__input {
            display: flex;
            flex-direction: column;
            color: $orange-formular;
            position: relative;
            padding: 15px 0 0;
            margin-top: 10px;

            &-alert {
                position: relative;
                top: -3em;
                width: 100%;
                text-align: start;
                font-size: 0.6em;
                display: block;
                margin: 0 auto;
                color: red;
                padding-left: 0.2em;
            }
        }

        & p {
            font-size: 1.1em;
            margin-top: 1em;
        }

        & button {
            @include btn-style($orange-formular);
            margin: 1em auto;
        }
    }

    .form__field {
    font-family: inherit;
    border: 0;
    width: 100%;
    border-bottom: 2px solid $orange-formular;
    outline: 0;
    font-size: 0.8em;
    color: $orange-formular;
    padding: 7px 0;
    background: transparent;
    transition: border-color 0.2s;
    margin: 0.2em auto;
    margin-bottom: 3em;

    &::placeholder {
        color: transparent;
    }

    &:placeholder-shown ~ .form__label {
        font-size: 0.8em;
        cursor: text;
        top: 20px;
    }
    }

    .form__label {
    position: absolute;
    top: 0;
    display: block;
    transition: 0.2s;
    font-size: 0.8em;
    color: $orange-formular;
    }

    .form__field:focus {
    ~ .form__label {
        position: absolute;
        top: 0;
        display: block;
        transition: 0.2s;
        font-size: 0.9em;
        color: $primary-color;
        font-weight:700;    
    }
    padding-bottom: 6px;  
    font-weight: 700;
    border-width: 3px;
    border-image: linear-gradient(to right, $orange-formular, $primary-color);
    border-image-slice: 1;
    }

    /* reset input */
    .form__field{
    &:required,&:invalid { box-shadow:none; }
    }

    .top-page {
        position: relative;
        left: 95vh;
        border-radius: 50%;
        width: 3vh;
        height: 3vh;
        font-size: 1.5em;
        padding: 0.5em;
        background-color: $primary-color;

            &:hover {
                transform: scale(1.3);
            }

            & a {
                text-decoration: none;
                color: white;
            }
    }

    .none {
        display: none;
        opacity: 0;
        transition: all 0.4s ease-in-out;
    }

    .active {
        display: flex;
        opacity: 1;
        transition: all 0.4s ease-in-out;
    }

    .v-enter-active,
    .v-leave-active {
    transition: all 0.75s ease-out;
    }

    .v-enter-to {
    height: auto;
    opacity: 1;
    }

    .v-enter-from {
    height: 0;
    opacity: 0;
    }

    .v-leave-to {
    height: auto;
    opacity: 0;
    }

    .v-leave-from {
    height: auto;
    opacity: 1;
    }


    @media screen and (min-width: 992px) {
        .row {
            flex-direction: column;
        }
    }

</style>