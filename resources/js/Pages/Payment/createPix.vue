<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import {mask} from 'vue-the-mask';

import ShowResult from '@/Components/ShowResult.vue';
</script>

<template>
    <Head title="Gerar Pix QRCode " />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gerar Pix QRCode  </h2>
        </template>

        <div class="py-12" v-if="this.success === false">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    
                    <form @submit.prevent="validatePayment"
                        class="max-w-md mx-auto m-20"
                    >

                        <div class="relative z-0 w-full mb-5 group">
                            <InputLabel for="externalReference" value="Digite o Pedido" />

                            <TextInput
                                id="externalReference"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.externalReference"
                                required
                                autofocus
                                autocomplete="externalReference"
                            />

                            <InputError class="mt-2" :message="form.errors.externalReference" />
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <InputLabel for="value" value="Valor em reais R$" />

                            <TextInput
                                id="value"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.value"
                                required
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
                            Gerar QRCode
                        </PrimaryButton>

                    </form>

                </div>
            </div>
        </div>

        <ShowResult
            :success="this.success" 
            :response="this.response" 
            :form="this.form"
            :title="'QRCode gerado com sucesso!'"
        >
            <img :src="'data:image/jpeg;base64, ' + this.response.data.encodedImage">
       
            <PrimaryButton @click="copyText" class="mt-10" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Pix Copia e Cola
            </PrimaryButton>

        </ShowResult>

    </AuthenticatedLayout>
</template>

<script>

const page = usePage();

export default {
    directives: {mask},
    components: {
        Head, 
        Link, 
        TextInput, 
        InputError, 
        InputLabel, 
        PrimaryButton,
        ShowResult
    },
    props: {
        billingType: String, 
        gateway: String
    }, 
    data() {
        return {
            form: useForm({
                value: '5000', 
                name: page.props.auth.user.name,
                cpfCnpj: '20.357.915/0001-66',
                billingType: this.billingType,
                gateway: this.gateway, 
                customer: page.props.auth.user.customer,
                userId: page.props.auth.user.id,
                externalReference: '48585'
            }),
            success: false,
            response: Object
        }
    }, 
    methods: {
        async validatePayment() {
           
            try {
                const validate = await axios.post(route('payment.validate'), this.form);
            } catch (error) {
                this.showErrorsValidated(error.response.data.errors);
                console.log('validate', error)

                return;
            }

            this.process();
        }, 

        async process() {

            try {
                const process = await axios.post(route('payment.process'), this.form);
            
                if (process.status == 200) {
                    this.success = true;
                    this.response = process.data;
                }

                console.log('process', process)

            } catch (error) {
                console.log('process', error)
            }
        }, 

        async savePayment() {

        },

        showErrorsValidated(data) {
            this.form.errors.value = data.value != undefined ? data.value[0] : '';
            this.form.errors.name = data.name != undefined ? data.name[0] : '';
            this.form.errors.cpfCnpj = data.cpfCnpj != undefined ? data.cpfCnpj[0] : '';
            this.form.errors.externalReference = data.externalReference != undefined ? data.externalReference[0] : '';
        },

        copyText() {
            const textToCopy = this.response.data.payload;
            
            // Cria um elemento de texto temporário
            const tempTextArea = document.createElement('textarea');
            tempTextArea.value = textToCopy;
            document.body.appendChild(tempTextArea);

            // Seleciona e copia o texto
            tempTextArea.select();
            document.execCommand('copy');

            // Remove o elemento de texto temporário
            document.body.removeChild(tempTextArea);

            // Feedback de cópia
            alert('Copiado!');
        }
    }
}

</script>
