<script setup>

import PrimaryUrl from '@/Components/PrimaryUrl.vue';

defineProps({
    title: {
        type: String,
        default: 'Processado com Sucesso!'
    },
    success: {
        type: Boolean,
        default: false
    },
    form: {
        type: Object,
    },
    response: {
        type: Object
    }
});
</script>

<template>
        <div class="py-12" v-if="this.success === true">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                    <div class="max-w-md mx-auto m-20">
                        <h3 class="text-2xl mb-5 text-center">
                            {{ this.title }}
                        </h3>
                        <div class="relative z-0 w-full mb-5 group">
                            <ul>
                                <li>
                                    Nome: {{ this.form.name }}                                   
                                </li>
                                <li>
                                    Documento: {{ this.form.cpfCnpj }}                                   
                                </li>  
                                <li>
                                    N° Pedido: {{ this.response.data.externalReference }}                                   
                                </li>                              
                                <li>
                                    Metodo de Pagamento: {{ this.response.data.billingType }}                                   
                                </li>
                                <li>
                                    Valor: R$ {{ this.response.data.value }}
                                </li>
                                <li>
                                    Data Vencimento: {{ this.response.data.dueDate }}
                                </li>
                            </ul>
                        </div>

                        <div class="relative z-0 w-full mb-5 group bg-black text-white text-center rounded-lg p-10">

                            {{ this.response.message }}
                        </div>

                        <div class="relative z-0 w-full mb-5 group bg-black text-white text-center rounded-lg p-10">

                            <slot />
                        </div>

                        

                        <PrimaryUrl :url="this.response.data.invoiceUrl" class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Visualizar Cobrança
                        </PrimaryUrl>

                    </div>
                </div>
            </div>
        </div> 
</template>
