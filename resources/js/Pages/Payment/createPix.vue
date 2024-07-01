<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import {mask} from 'vue-the-mask';

</script>

<template>
    <Head title="Gerar Pix QRCode " />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gerar Pix QRCode  </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    
                    <form @submit.prevent="validatePayment"
                        class="max-w-md mx-auto m-20"
                    >
                        <div class="relative z-0 w-full mb-5 group">
                            <InputLabel for="value" value="Valor em reais R$" />

                            <TextInput
                                id="value"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.value"
                                
                                autofocus
                                autocomplete="value"
                                v-mask="['#.##','##.##','###.##','####.##','#####.##','######.##']"
                            />

                            <InputError class="mt-2" :message="form.errors.value" />
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <InputLabel for="name" value="Name" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                            />

                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <InputLabel for="cpfCnpj" value="Digite o CPF ou CNPJ" />

                            <TextInput
                                id="cpfCnpj"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.cpfCnpj"
                                required
                                autofocus
                                autocomplete="cpfCnpj"
                                v-mask="['###.###.###-##','##.###.###/####-##']"
                            />

                            <InputError class="mt-2" :message="form.errors.cpfCnpj" />
                        </div>

                        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Gerar Boleto
                        </PrimaryButton>

                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>


export default {
    directives: {mask},
    components: {
        Head, 
        Link, 
        TextInput, 
        InputError, 
        InputLabel, 
        PrimaryButton
    },
    props: {

    }, 
    data() {
        return {
            form: useForm({
                value: '', 
                name: '', 
                cpfCnpj: ''
            })
        }
    }, 
    methods: {
        async validatePayment() {
           
            try {
                const validate = await axios.post(route('payment.validate'), this.form);
            } catch (error) {
                this.showErrorsValidated(error.response.data.errors);
                console.log('validate', error)
            }
        }, 

        async createPayment() {

        }, 

        async finallyPayment() {

        }, 

        async savePayment() {

        },

        showErrorsValidated(data) {
            this.form.errors.value = data.value != undefined ? data.value[0] : '';
            this.form.errors.name = data.name != undefined ? data.name[0] : '';
            this.form.errors.cpfCnpj = data.cpfCnpj != undefined ? data.cpfCnpj[0] : '';
        }
    }
}

</script>
