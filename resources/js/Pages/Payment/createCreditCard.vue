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
    <Head title="Pagar Com Cartão de Crédito" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pagar Com Cartão de Crédito</h2>
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

                        <div class="relative z-0 w-full mb-5 group">
                            <InputLabel for="holderName" value="Digite o nome como no cartão" />

                            <TextInput
                                id="holderName"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.holderName"
                                required
                                autofocus
                                autocomplete="holderName"
                            />

                            <InputError class="mt-2" :message="form.errors.holderName" />
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <InputLabel for="number" value="Numero do cartão" />

                            <TextInput
                                id="number"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.number"
                                
                                autofocus
                                autocomplete="number"
                                v-mask="'####-####-####-####'"
                            />

                            <InputError class="mt-2" :message="form.errors.number" />
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <InputLabel for="expiryMonth" value="Mês validade" />

                            <TextInput
                                id="expiryMonth"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.expiryMonth"
                                required
                                autofocus
                                autocomplete="expiryMonth"
                                v-mask="'##'"
                            />

                            <InputError class="mt-2" :message="form.errors.expiryMonth" />
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <InputLabel for="expiryYear" value="Ano validate" />

                            <TextInput
                                id="expiryYear"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.expiryYear"
                                required
                                autofocus
                                autocomplete="expiryYear"
                                v-mask="'####'"
                            />

                            <InputError class="mt-2" :message="form.errors.expiryYear" />
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <InputLabel for="ccv" value="CCV" />

                            <TextInput
                                id="ccv"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.ccv"
                                required
                                autofocus
                                autocomplete="ccv"
                                v-mask="'###'"
                            />

                            <InputError class="mt-2" :message="form.errors.ccv" />
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <InputLabel for="email" value="Email" />

                            <TextInput
                                id="email"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                required
                                autofocus
                                autocomplete="email"
                            />

                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <InputLabel for="postalCode" value="CEP" />

                            <TextInput
                                id="postalCode"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.postalCode"
                                required
                                autofocus
                                autocomplete="postalCode"
                                v-mask="'#####-###'"
                            />

                            <InputError class="mt-2" :message="form.errors.postalCode" />
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <InputLabel for="addressComplement" value="Endereço" />

                            <TextInput
                                id="addressComplement"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.addressComplement"
                                required
                                autofocus
                                autocomplete="addressComplement"
                            />

                            <InputError class="mt-2" :message="form.errors.addressComplement" />
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <InputLabel for="addressNumber" value="Numero da Casa" />

                            <TextInput
                                id="addressNumber"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.addressNumber"
                                required
                                autofocus
                                autocomplete="addressNumber"
                            />

                            <InputError class="mt-2" :message="form.errors.addressNumber" />
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <InputLabel for="phone" value="Phone" />

                            <TextInput
                                id="phone"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.phone"
                                required
                                autofocus
                                autocomplete="phone"
                                v-mask="'##-#####-####'"
                            />

                            <InputError class="mt-2" :message="form.errors.phone" />
                        </div>

                        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Processar Pagamento
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
                value: '88', 
                name: 'adfsadf', 
                holderName: 'adfsadf',
                number: '4555',
                expiryMonth: '12',
                expiryYear: '2025',
                ccv: '159',
                email: 'teste@gmail.com',
                cpfCnpj: '155.456.849-85',
                postalCode: '78888-599',
                addressNumber: '45',
                addressComplement: 'rua teste',
                phone: '64-959899-48145',
                remoteIp: '4585'
            })
        }
    }, 
    methods: {
        async validatePayment() {

            this.showErrorsValidated([]);
           
            try {
                const validate = await axios.post(route('payment.validate-credit-card'), this.form);
            } catch (error) {
               // console.log('validate', error)
                this.showErrorsValidated(error.response.data.errors);
                
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
            this.form.errors.holderName = data.holderName != undefined ? data.holderName[0] : '';

            this.form.errors.expiryMonth = data.expiryMonth != undefined ? data.expiryMonth[0] : '';
            this.form.errors.number = data.number != undefined ? data.number[0] : '';
            this.form.errors.expiryYear = data.expiryYear != undefined ? data.expiryYear[0] : '';
            this.form.errors.ccv = data.ccv != undefined ? data.ccv[0] : '';
            this.form.errors.email = data.email != undefined ? data.email[0] : '';
            this.form.errors.postalCode = data.postalCode != undefined ? data.postalCode[0] : '';
            this.form.errors.addressNumber = data.addressNumber != undefined ? data.addressNumber[0] : '';
            this.form.errors.addressComplement = data.addressComplement != undefined ? data.addressComplement[0] : '';
            this.form.errors.phone = data.phone != undefined ? data.phone[0] : '';

        }
    }
}

</script>
