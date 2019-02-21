<template>
    <card class="flex justify-center">
        <div class="flex  flex-wrap px-3 py-3 items-center justify-center">
            <div class="flex-none">
                <img :src="getImageFromType()" width="100" />
            </div>

            <div class="ml-8">
                <h1 class="text-center text-3xl text-80 font-light capitalize mb-2">{{ name }}</h1>
                <toggle-button v-model="enabled" v-on:change="handleResource" :color="switchColor" :width="80" :height="40" :sync="true" />
            </div>
        </div>
        <div ref="modals">
            <modal ref="modalConfirm" v-if="modalConfirm" :name="'modalConfirm'" :align="'flex justify-end'">
                <div slot="container">
                    <h2 class="mb-6 text-90 font-normal text-xl">{{ __('Confirmar cambio') }}</h2>
                    <p class="text-80 leading-normal" v-if="enabled">{{ __('¿Estas seguro de activar este apartado?') }}</p>
                    <p class="text-80 leading-normal" v-if="!enabled">{{ __('¿Estas seguro de desactivar este apartado?') }}</p>
                </div>
                <div slot="buttons">
                    <div class="ml-auto">
                        <button type="button" @click.prevent="cancelChange" class="btn text-80 font-normal h-9 px-3 mr-3 btn-link">
                            {{ __('Cancel') }}
                        </button>

                        <button id="confirm-overwrite-button" ref="confirmButton" @click.prevent="setType" class="btn btn-default btn-danger">
                            {{ processButton }}
                        </button>
                    </div>
                </div>
            </modal>
        </div>
    </card>
</template>

<script>
import { ToggleButton } from 'vue-js-toggle-button';
import Modal from './Modal';

function titleCase(str) {
    return str
        .toLowerCase()
        .split(' ')
        .map(function(word) {
            return word.replace(word[0], word[0].toUpperCase());
        })
        .join(' ');
}

export default {
    key: 'vaya',
    components: {
        ToggleButton,
        Modal,
    },
    props: ['card'],

    data: () => ({
        enabled: false,
        original: false,
        modalConfirm: false,
        switchColor: { checked: '#21b978', unchecked: '#dae1e7', disabled: '#eef1f4' },
    }),

    methods: {
        getImageFromType() {
            return `/assets/temply/svgs/${this.card.type}.svg`;
        },

        handleResource() {
            this.modalConfirm = true;
        },

        setType() {
            Nova.request()
                .post('/nova-vendor/temply-resources-selector/set-type/' + this.card.type, { value: this.enabled })
                .then(() => {
                    this.modalConfirm = false;
                    if (this.enabled) {
                        this.$toasted.show(this.__('Apartado') + ' ' + titleCase(this.card.type) + ' ' + this.__('activado'), { type: 'success' });
                    } else {
                        this.$toasted.show(this.__('Apartado') + ' ' + titleCase(this.card.type) + ' ' + this.__('desactivado'), { type: 'success' });
                    }
                });
        },

        cancelChange() {
            this.enabled = this.original;
            this.modalConfirm = false;
        },
    },

    mounted() {
        Nova.request()
            .get('/nova-vendor/temply-resources-selector/type/' + this.card.type)
            .then(response => {
                if (response.data.exists) {
                    this.enabled = response.data.exists;
                    this.original = response.data.exists;
                }
            });
    },

    computed: {
        name() {
            return this.__(this.card.type);
        },

        processButton() {
            if (this.enabled) {
                return this.__('Si, activar');
            }

            return this.__('Si, desactivar');
        },
    },
};
</script>
